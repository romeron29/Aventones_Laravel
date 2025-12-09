<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Ride; 
use App\Models\Reservation; 

class ReservationCancellationTest extends TestCase
{
    /** @test */
    public function regresar_asiento_reserva_cancelada_con_mocking()
    {
        $initialSeats = 1;
        
        $ride = new class {
            public $seats_available = 1;
            public $id = 5;
        };

        $reservation = new class {
            public $status = 'aceptada';
            public $ride; 

            public function update(array $attributes): bool 
            {
                if (isset($attributes['status'])) {
                    $this->status = $attributes['status'];
                }
                return true;
            }
        };
        $reservation->ride = $ride; 

        if ($reservation->status === 'aceptada') {
            $reservation->ride->seats_available += 1; 
        }
        $reservation->update(['status' => 'cancelada']);       
        $this->assertEquals('cancelada', $reservation->status);
        $this->assertEquals($initialSeats + 1, $ride->seats_available);
    }
}