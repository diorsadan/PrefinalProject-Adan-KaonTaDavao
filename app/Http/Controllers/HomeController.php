<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // top 6 open eateries by average rating
        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_open', true)
            ->orderByDesc('reviews_avg_rating')
            ->take(6)
            ->get();

        return view('home', compact('eateries'));
    }
}
