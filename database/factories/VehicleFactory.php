<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Provider\en_US\Person; 
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    protected $model = Vehicle::class;
    public function definition(): array
    {
        $fakerForced = FakerFactory::create('en_US');
        $user = User::factory()->create(['role' => 'chofer']);
        return [
            'user_id' => $user->id,
            'placa' => $fakerForced->unique()->regexify('[A-Z]{3}[0-9]{3}'), 
            'marca' => $fakerForced->randomElement(['Toyota', 'Nissan', 'Honda','AUDI','Ford','BMW']),
            'modelo' => $fakerForced->randomElement(['Corolla', 'Sentra', 'Civic','A4','Explorer','X5']),
            'year' => $fakerForced->year(),
            'color' => $fakerForced->colorName(),
            'capacity' => $fakerForced->numberBetween(2, 6),
        ];
    }
}
