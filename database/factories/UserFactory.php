<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Provider\en_US\Person; 
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $fakerForced = FakerFactory::create('en_US');
        return [
        'name' => $fakerForced->name(),
        'lastname' => $fakerForced->lastName(),
        'cedula' => $fakerForced->unique()->randomNumber(8),
        'birthdate' => $fakerForced->date(),
        'email' => $fakerForced->unique()->safeEmail(),
        'phone' => $fakerForced->phoneNumber(),
        'role' => $fakerForced->randomElement(['chofer', 'pasajero']),
        'status' => 'activo', 
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa',
        'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
