<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Suki ni Adan', 'Budget Meal', 'Halal', 'Open 24 Hours', 'Aircon', 'Free Sabaw'];

        foreach ($names as $name) {
            Feature::create(['name' => $name]);
        }
    }
}
