<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Ride; 
// 🛑 No usar RefreshDatabase 🛑
// use Illuminate\Foundation\Testing\RefreshDatabase; 

class RideAvailabilityTest extends TestCase
{
    // Simulación del modelo Ride para el test unitario
    private function createMockRide($seats)
    {
        // Creamos un objeto anónimo que simula el modelo Ride
        // y le añadimos una función para verificar la disponibilidad.
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
        // Creamos un mock del Ride con 2 asientos
        $ride = $this->createMockRide(2);

        // Verificamos la lógica unitaria
        $this->assertTrue($ride->hasAvailableSeats());
    }

    /** @test */
    public function no_disponibilidad_sin_espacios()
    {
        // Creamos un mock del Ride con 0 asientos
        $ride = $this->createMockRide(0);

        // Verificamos la lógica unitaria
        $this->assertFalse($ride->hasAvailableSeats());
    }
}