<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', compact('districts'));
    }

    public function show(District $district)
    {
        $district->load([
            'eateries' => fn ($query) => $query->with(['district', 'features'])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->orderBy('name'),
        ]);

        // counted through the hasManyThrough relationship (districts -> eateries -> reviews)
        $district->loadCount('reviews');

        return view('districts.show', compact('district'));
    }
}
