<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Ride; 

class RideAvailabilityTest extends TestCase
{
    private function createMockRide($seats)
    {

        $mockRide = new class {
            public $seats_available;

            public function hasAvailableSeats(): bool 
            {
                return $this->seats_available > 0;
            }
        };
        $mockRide->seats_available = $seats;
        return $mockRide;
    }

    /** @test */
    public function disponibilidad_hay_espacios_disponibles()
    {
        $ride = $this->createMockRide(2);

        $this->assertTrue($ride->hasAvailableSeats());
    }

    /** @test */
    public function no_disponibilidad_sin_espacios()
    {
        $ride = $this->createMockRide(0);

        $this->assertFalse($ride->hasAvailableSeats()); #Verificacion prueba unitaria
    }
}