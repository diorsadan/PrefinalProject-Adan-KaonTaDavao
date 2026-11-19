<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Eatery>
 */
class EateryFactory extends Factory
{
    /**
     * Define the model's default state.
     * district_id is not set here; the seeder gives each eatery a random district.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // e.g. "Kainan ni Aling Maria" (unique first name keeps every name unique)
        $name = fake()->randomElement(['Carinderia ni', 'Kainan ni', 'Lutong Bahay ni', 'Turo-Turo ni', 'Sinugbahan ni', 'Pares-an ni'])
            .' '.fake()->randomElement(['Aling', 'Mang', 'Nanay', 'Tatay', 'Manang', 'Manong'])
            .' '.fake()->unique()->firstName();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->buildingNumber().' '.fake()->randomElement(['Quirino Ave.', 'Claveria St.', 'J.P. Laurel Ave.', 'C.M. Recto St.', 'Bonifacio St.', 'Roxas Ave.', 'Ponciano Reyes St.', 'Ilustre St.', 'McArthur Hwy.', 'Magsaysay Ave.']).', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement(['Adobong Manok', 'Sinigang na Baboy', 'Kare-Kare', 'Lechon Kawali', 'Bulalo', 'Pancit Canton', 'Inihaw na Panga', 'Sisig', 'Pinakbet', 'Tinolang Manok', 'Kinilaw na Tuna', 'Chicken Inasal']),
            'is_open' => true,
        ];
    }

    // Eatery::factory()->closed() makes a closed eatery
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}
