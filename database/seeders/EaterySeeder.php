<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // My eatery, made by hand
        $poblacion = District::where('name', 'Poblacion')->first();

        $eatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => 'Carinderia ni Adan',
            'slug' => Str::slug('Carinderia ni Adan'),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $featureIds = Feature::whereIn('name', ['Suki ni Adan', 'Budget Meal'])->pluck('id');
        $eatery->features()->sync($featureIds);

        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-1203',
            'expires_on' => '2027-12-03',
        ]);

        $eatery->dishes()->create(['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true]);
        $eatery->dishes()->create(['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false]);
        $eatery->dishes()->create(['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false]);

        // 14 factory eateries: numbers 1-11 are open, 12-14 are closed
        $districts = District::all();
        $allFeatureIds = Feature::pluck('id');

        for ($i = 1; $i <= 14; $i++) {
            if ($i <= 11) {
                $factory = Eatery::factory();
            } else {
                $factory = Eatery::factory()->closed();
            }

            $eatery = $factory->create(['district_id' => $districts->random()->id]);

            if ($i == 1) {
                // the first one gets an expired permit on purpose
                Permit::factory()->create([
                    'eatery_id' => $eatery->id,
                    'expires_on' => now()->subMonths(3),
                ]);
            } else {
                Permit::factory()->create(['eatery_id' => $eatery->id]);
            }

            Dish::factory()->count(rand(2, 5))->create(['eatery_id' => $eatery->id]);

            $eatery->features()->attach($allFeatureIds->random(rand(1, 3)));
        }
    }
}
