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
        // reviews count uses the hasManyThrough relationship
        $district->loadCount(['eateries', 'reviews']);

        $eateries = $district->eateries()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        return view('districts.show', compact('district', 'eateries'));
    }
}
