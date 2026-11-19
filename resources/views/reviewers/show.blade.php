@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="mb-6 text-stone-600">{{ $user->reviews->count() }} {{ $user->reviews->count() == 1 ? 'review' : 'reviews' }} written</p>

    <div class="space-y-3">
        @forelse ($user->reviews as $review)
            <div class="rounded border border-stone-200 bg-white p-4">
                <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                    <a href="{{ route('eateries.show', $review->eatery) }}" class="font-medium hover:text-orange-700">{{ $review->eatery->name }}</a>
                    <x-rating :rating="$review->rating" />
                </div>
                <p class="mt-2">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-stone-500">No reviews yet</p>
        @endforelse
    </div>
@endsection
