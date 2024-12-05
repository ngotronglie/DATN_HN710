<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->optional()->address(),
            'phone' => fake()->optional()->phoneNumber(),
            'avatar' => fake()->optional()->imageUrl(200, 200, 'people'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['0', '1', '2']),
            'date_of_birth' => fake()->optional()->dateTimeBetween('-60 years', '-18 years')?->format('Y-m-d'),
            'email_verified_at' => fake()->optional()->dateTime(),
            'email_verification_expires_at' => fake()->optional()->dateTimeBetween('now', '+1 year'),
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
