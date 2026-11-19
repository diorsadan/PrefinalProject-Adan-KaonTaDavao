@props(['eatery'])

@php
    $prices = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
@endphp

{{-- Only uses data the controller already loaded: district, features, reviews_count, reviews_avg_rating --}}
<div class="flex flex-col gap-2 rounded-lg border border-stone-200 bg-white p-4 shadow-sm">
    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('eateries.show', $eatery) }}" class="text-lg font-semibold hover:text-orange-700">{{ $eatery->name }}</a>
        @if (! $eatery->is_open)
            <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Closed</span>
        @endif
    </div>

    <div class="text-sm text-stone-600">
        <a href="{{ route('districts.show', $eatery->district) }}" class="hover:text-orange-700">{{ $eatery->district->name }}</a>
        · <span class="font-medium text-green-700">{{ $prices[$eatery->price_range] ?? '' }}</span>
    </div>

    @if ($eatery->specialty)
        <p class="text-sm">Specialty: {{ $eatery->specialty }}</p>
    @endif

    <div class="text-sm">
        @if ($eatery->reviews_count > 0)
            <span>{{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count == 1 ? 'review' : 'reviews' }})</span>
            <x-rating :rating="$eatery->reviews_avg_rating" />
        @else
            <span class="text-stone-500">No reviews yet</span>
        @endif
    </div>

    @if ($eatery->features->isNotEmpty())
        <div class="flex flex-wrap gap-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-800 hover:bg-orange-200">{{ $feature->name }}</a>
            @endforeach
        </div>
    @endif
</div>
