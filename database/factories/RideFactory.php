<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use Faker\Provider\en_US\Person; 
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ride::class;
    public function definition(): array
    {
        $fakerForced = FakerFactory::create('en_US');
        $user = User::factory()->create(['role' => 'chofer']);
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id, 'capacity' => 4]);
        
        $origin = $this->faker->city(); // <-- CORREGIDO: Usando city()
        $destination = $this->faker->city();

        return [
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'name' => 'Viaje de ' . $origin . ' a ' . $destination,
            'origin' => $origin,
            'destination' => $destination,
            'departure_time' => $fakerForced->dateTimeBetween('+1 day', '+1 week'),
            'cost' => $fakerForced->randomFloat(2, 5, 50),
            'seats_available' => $fakerForced->numberBetween(1, 4),
        ];
    }
}
