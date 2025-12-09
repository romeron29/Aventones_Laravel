<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;

class RideCreationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function un_chofer_puede_crear_un_viaje_correctamente()
    {
        $chofer = User::factory()->create([
            'role' => 'chofer',
            'status' => 'activo',
        ]);
        $this->actingAs($chofer);

        $vehicle = Vehicle::factory()->create([
            'user_id' => $chofer->id,
            'capacity' => 5,
        ]);
        # POST para creacion de viaje
        $response = $this->post('/rides', [ 
            'vehicle_id' => $vehicle->id,
            'origin' => 'San José',
            'destination' => 'Cartago',
            'departure_time' => now()->addHours(3)->format('Y-m-d H:i:s'), // Hora futura
            'cost' => 5000.50,
            'seats_available' => 3,
        ]);

        #Confirmacion ride creado en la base de datos
        $response->assertStatus(302);
        $response->assertSessionHas('success', '¡Viaje publicado exitosamente!'); 

        #Verificacion de registro viaje con informacion correcta
        $this->assertDatabaseHas('rides', [
            'user_id' => $chofer->id,
            'vehicle_id' => $vehicle->id,
            'origin' => 'San José',
            'seats_available' => 3,
            'cost' => 5000.50,
        ]);

        $this->assertDatabaseCount('rides', 1);
    }
}
