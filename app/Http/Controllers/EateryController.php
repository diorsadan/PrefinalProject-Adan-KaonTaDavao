<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;

class EateryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            // search name OR specialty, grouped so it combines correctly with the other filters
            ->when($request->input('q'), function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name', 'like', '%'.$q.'%')
                        ->orWhere('specialty', 'like', '%'.$q.'%');
                });
            })
            ->when($request->input('district'), function ($query, $districtId) {
                $query->where('district_id', $districtId);
            })
            ->when($request->input('feature'), function ($query, $featureName) {
                $query->whereHas('features', function ($query) use ($featureName) {
                    $query->where('name', $featureName);
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString(); // keep the filters in the pagination links

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews' => fn ($query) => $query->latest()->with('user'),
        ]);

        // for the Reviewer select in the review form
        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eatery $eatery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eatery $eatery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eatery $eatery)
    {
        //
    }
}
