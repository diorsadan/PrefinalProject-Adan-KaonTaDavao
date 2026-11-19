<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // My eatery: Tita Adan's review + 2 from random users = 3 reviews
        $mine = Eatery::where('slug', 'carinderia-ni-adan')->first();
        $tita = User::where('email', 'tita.adan@kaonta.test')->first();

        $mine->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Adan.',
        ]);

        for ($i = 0; $i < 2; $i++) {
            Review::factory()->create([
                'eatery_id' => $mine->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // Open factory eateries get 0-6 reviews each; closed ones get none
        $openEateries = Eatery::where('is_open', true)
            ->where('id', '!=', $mine->id)
            ->get();

        foreach ($openEateries as $eatery) {
            $count = rand(0, 6);

            for ($i = 0; $i < $count; $i++) {
                Review::factory()->create([
                    'eatery_id' => $eatery->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
