<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use Illuminate\Http\Request;

class EateryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // load everything the card needs here, so the card never runs a query
        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        return view('eateries.index', compact('eateries'));
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
        $eatery->load(['district', 'features', 'permit', 'dishes', 'reviews.user'])
            ->loadCount('reviews')
            ->loadAvg('reviews', 'rating');

        return view('eateries.show', compact('eatery'));
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
