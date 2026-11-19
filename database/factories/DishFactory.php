<?php

namespace Database\Factories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
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
            'name' => fake()->randomElement(['Adobong Manok', 'Sinigang na Baboy', 'Kare-Kare', 'Lechon Kawali', 'Bulalo', 'Pancit Canton', 'Inihaw na Panga', 'Sisig', 'Pinakbet', 'Lumpiang Shanghai', 'Halo-Halo', 'Chicken Inasal', 'Bicol Express', 'Dinuguan', 'Puto Maya']),
            'price' => fake()->randomFloat(2, 30, 350),
            'is_bestseller' => fake()->boolean(20), // 20% chance of true, so mostly false
        ];
    }
}
