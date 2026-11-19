@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $district->name }}</h1>
    <p class="mb-6 text-stone-600">{{ $district->reviews_count }} {{ $district->reviews_count == 1 ? 'review' : 'reviews' }} in {{ $district->name }}</p>

    @if ($district->eateries->isEmpty())
        <p class="text-stone-500">No eateries in this district yet.</p>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($district->eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection
