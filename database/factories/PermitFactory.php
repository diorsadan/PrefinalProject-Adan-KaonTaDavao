<?php

namespace Database\Factories;

use App\Models\Permit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     * eatery_id is not set here; the seeder passes it in.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 5-digit number, so it can never be the same as DVO-2026-1203
            'permit_no' => 'DVO-2026-'.fake()->unique()->numberBetween(10000, 99999),
            'expires_on' => fake()->dateTimeBetween('-1 year', '+2 years'),
        ];
    }
}
