<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $data['is_open'] ?? false,
        ]);

        $eatery->permit()->create([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('success', 'Eatery added.');
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
        $eatery->load(['permit', 'features']);

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();

        $eatery->update([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $data['is_open'] ?? false,
        ]);

        $eatery->permit()->update([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        // sync() makes the pivot rows exactly this list (adds checked ones, removes unchecked ones)
        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('success', 'Eatery updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eatery $eatery)
    {
        // delete the children first, or the foreign keys would block deleting the eatery
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();

        $eatery->delete();

        return redirect()->route('eateries.index')->with('success', 'Eatery deleted.');
    }
}
