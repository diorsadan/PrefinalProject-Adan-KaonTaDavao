@extends('layouts.app')

@section('content')
    <section class="mb-8">
        <h1 class="mb-2 text-3xl font-bold">Maayong pag-abot!</h1>
        <p class="text-stone-600">Find the best carinderias and eateries around Davao City.</p>
    </section>

    <div class="mb-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-stone-200 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-orange-700">{{ $eateryCount }}</div>
            <div class="text-sm text-stone-600">Eateries</div>
        </div>
        <div class="rounded-lg border border-stone-200 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-orange-700">{{ $districtCount }}</div>
            <div class="text-sm text-stone-600">Districts</div>
        </div>
        <div class="rounded-lg border border-stone-200 bg-white p-4 text-center shadow-sm">
            <div class="text-3xl font-bold text-orange-700">{{ $reviewCount }}</div>
            <div class="text-sm text-stone-600">Reviews</div>
        </div>
    </div>

    <h2 class="mb-4 text-xl font-semibold">Top Rated</h2>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($topRated as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>

    <p class="mt-6">
        <a href="{{ route('eateries.index') }}" class="font-medium text-orange-700 hover:underline">See all eateries →</a>
    </p>
@endsection
