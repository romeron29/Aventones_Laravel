<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Ride;
use Faker\Provider\en_US\Person; 
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Reservation::class;
    public function definition(): array
    {
        $pasajero = User::factory()->create(['role' => 'pasajero']);
        $ride = Ride::factory()->create(); // Esto usará el RideFactory corregido
        $fakerForced = FakerFactory::create('en_US');
        return [
            'user_id' => $pasajero->id,
            'ride_id' => $ride->id,
            'status' => $fakerForced->randomElement(['pendiente', 'aceptada', 'rechazada', 'cancelada']),
        ];
    }
}
