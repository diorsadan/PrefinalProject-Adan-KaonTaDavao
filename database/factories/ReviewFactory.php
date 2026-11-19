<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     * eatery_id and user_id are not set here; the seeder passes them in.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            // exactly 10 words, so it is always longer than 10 characters
            'body' => fake()->sentence(10, false),
        ];
    }
}
