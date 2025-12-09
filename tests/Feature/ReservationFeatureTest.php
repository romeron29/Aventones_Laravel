<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Ride;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationFeatureTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
public function reserva_resta_asientos_disponibles_al_aceptarse()
    {
        Mail::fake(); 

        $chofer = User::factory()->create(attributes: ['role' => 'chofer', 'status' => 'activo']);
        $choferVehicle = Vehicle::factory()->create(['user_id' => $chofer->id, 'capacity' => 4]);

        $initialSeats = 3;
        $ride = Ride::factory()->create([
            'user_id' => $chofer->id,
            'vehicle_id' => $choferVehicle->id,
            'seats_available' => $initialSeats, 
        ]);

        $pasajero = User::factory()->create(['role' => 'pasajero', 'status' => 'activo']);
        $this->actingAs($pasajero); 

        $responseStore = $this->post("/rides/{$ride->id}/reserve"); 

        $responseStore->assertStatus(302); 
        $this->assertDatabaseHas('reservations', [
            'user_id' => $pasajero->id,
            'ride_id' => $ride->id,
            'status' => 'pendiente',
        ]);
        
        $reservation = Reservation::where('user_id', $pasajero->id)->first();

        $this->actingAs($chofer); 
        
        $responseAccept = $this->post("/reservations/{$reservation->id}/approve");


        $responseAccept->assertStatus(302);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'aceptada',
        ]);
        
        $this->assertEquals($initialSeats - 1, $ride->fresh()->seats_available);
    }
}
