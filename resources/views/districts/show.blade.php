@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $district->name }}</h1>
    <p class="mb-6 text-stone-600">
        {{ $district->eateries_count }} {{ $district->eateries_count == 1 ? 'eatery' : 'eateries' }}
        · {{ $district->reviews_count }} {{ $district->reviews_count == 1 ? 'review' : 'reviews' }}
    </p>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-stone-500">No eateries in this district yet.</p>
        @endforelse
    </div>
@endsection
