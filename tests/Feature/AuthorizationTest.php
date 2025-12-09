<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
public function pasajero_no_puede_crear_vehiculo()
    {
        $pasajero = User::factory()->create(['role' => 'pasajero', 'status' => 'activo']);
        $this->actingAs($pasajero);

        $response = $this->get('/vehicles/create');

        $response->assertStatus(403)
                 ->assertForbidden();
    }

}
