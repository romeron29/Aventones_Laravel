<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;
/** @test */
    public function el_usuario_puede_registrarse_correctamente_y_queda_pendiente()
    {
        #petición POST de registro
        $response = $this->post('/register', [
            'name' => 'Nombre',
            'lastname' => 'Prueba',
            'cedula' => '798745',
            'birthdate' => '2000-01-01',
            'email' => 'prueba@email.com',
            'phone' => '9446456',
            'role' => 'pasajero',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        #Verificacion creacion en la bd
        $this->assertDatabaseHas('users', [
            'email' => 'prueba@email.com',
            'status' => 'pendiente', #'pendiente' al inicio
            'role' => 'pasajero',
        ]);

        $response->assertRedirect('/login') 
                 ->assertSessionHas('success'); 
    }

    /** @test */
    public function el_login_falla_si_la_cuenta_esta_pendiente()
    {
        #Se crea un usuario 'pendiente'
        $user = User::factory()->create([
            'email' => 'pending@test.com',
            'password' => bcrypt('123456'),
            'status' => 'pendiente',
        ]);

        #petición POST de login
        $response = $this->post('/login', [
            'email' => 'pending@test.com',
            'password' => '123456',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest(); 
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->get('email')[0] === 'Tu cuenta aún está pendiente de activación.';
        });
    }
}
