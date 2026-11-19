@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <h1 class="text-3xl font-bold">{{ $eatery->name }}</h1>
            @if (! $eatery->is_open)
                <span class="rounded bg-red-100 px-2 py-0.5 text-sm font-semibold text-red-700">Closed</span>
            @endif
        </div>
        <p class="mt-1 text-stone-600">
            <a href="{{ route('districts.show', $eatery->district) }}" class="hover:text-orange-700">{{ $eatery->district->name }}</a>
            · {{ $eatery->address }}
        </p>
        <p class="mt-1">Price range: {{ ucfirst($eatery->price_range) }}</p>
        @if ($eatery->specialty)
            <p>Specialty: {{ $eatery->specialty }}</p>
        @endif
        <p class="mt-2">
            @if ($eatery->reviews_count > 0)
                {{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count == 1 ? 'review' : 'reviews' }})
                <x-rating :rating="$eatery->reviews_avg_rating" />
            @else
                <span class="text-stone-500">No reviews yet</span>
            @endif
        </p>
        @if ($eatery->features->isNotEmpty())
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach ($eatery->features as $feature)
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-800 hover:bg-orange-200">{{ $feature->name }}</a>
                @endforeach
            </div>
        @endif
    </div>

    @if ($eatery->permit)
        <div class="mb-6 rounded border border-stone-200 bg-white p-4 text-sm">
            Business permit: <span class="font-mono">{{ $eatery->permit->permit_no }}</span>,
            expires {{ $eatery->permit->expires_on->format('M d, Y') }}
            @if ($eatery->permit->expires_on->isPast())
                <span class="ml-1 rounded bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Expired</span>
            @endif
        </div>
    @endif

    <h2 class="mb-3 text-xl font-semibold">Menu</h2>
    <ul class="mb-8 divide-y divide-stone-200 rounded border border-stone-200 bg-white">
        @forelse ($eatery->dishes as $dish)
            <li class="flex justify-between px-4 py-2">
                <span>
                    {{ $dish->name }}
                    @if ($dish->is_bestseller)
                        <span class="ml-1 rounded bg-amber-100 px-2 py-0.5 text-xs text-amber-800">Bestseller</span>
                    @endif
                </span>
                <span>₱{{ number_format($dish->price, 2) }}</span>
            </li>
        @empty
            <li class="px-4 py-2 text-stone-500">No dishes yet.</li>
        @endforelse
    </ul>

    <h2 class="mb-3 text-xl font-semibold">Reviews</h2>
    <div class="space-y-3">
        @forelse ($eatery->reviews as $review)
            <div class="rounded border border-stone-200 bg-white p-4">
                <div class="flex justify-between text-sm">
                    <a href="{{ route('reviewers.show', $review->user) }}" class="font-medium hover:text-orange-700">{{ $review->user->name }}</a>
                    <x-rating :rating="$review->rating" />
                </div>
                <p class="mt-1">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-stone-500">No reviews yet</p>
        @endforelse
    </div>
@endsection
