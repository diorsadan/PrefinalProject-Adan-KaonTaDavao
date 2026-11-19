@extends('layouts.app')

@section('content')
    @php
        $prices = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    @endphp

    {{-- Eatery details --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="text-3xl font-bold">{{ $eatery->name }}</h1>
                @if ($eatery->is_open)
                    <span class="rounded bg-green-100 px-2 py-0.5 text-sm font-semibold text-green-700">Open</span>
                @else
                    <span class="rounded bg-red-100 px-2 py-0.5 text-sm font-semibold text-red-700">Closed</span>
                @endif
            </div>
            <p class="mt-1 text-stone-600">
                <a href="{{ route('districts.show', $eatery->district) }}" class="hover:text-orange-700">{{ $eatery->district->name }}</a>
                · {{ $eatery->address }}
            </p>
            <p class="mt-1">Price range: <span class="font-medium text-green-700">{{ $prices[$eatery->price_range] ?? '' }}</span></p>
            @if ($eatery->specialty)
                <p>Specialty: {{ $eatery->specialty }}</p>
            @endif

            @if ($eatery->features->isNotEmpty())
                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach ($eatery->features as $feature)
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" class="rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-800 hover:bg-orange-200">{{ $feature->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex gap-2">
            <a href="{{ route('eateries.edit', $eatery) }}" class="rounded border border-stone-300 bg-white px-4 py-2 hover:bg-stone-100">Edit</a>
            <form method="POST" action="{{ route('eateries.destroy', $eatery) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>

    {{-- Permit --}}
    @if ($eatery->permit)
        <div class="mb-6 rounded border border-stone-200 bg-white p-4 text-sm">
            <p>Permit No.: <span class="font-mono">{{ $eatery->permit->permit_no }}</span></p>
            <p>Expires on: {{ $eatery->permit->expires_on->format('M d, Y') }}</p>
            @if ($eatery->permit->expires_on->lt(today()))
                <p class="mt-1 font-semibold text-red-600">Permit expired</p>
            @endif
        </div>
    @endif

    {{-- Dishes --}}
    <h2 class="mb-3 text-xl font-semibold">Dishes</h2>
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

    {{-- Review form, only for open eateries --}}
    <div class="mb-8">
        @if ($eatery->is_open)
            <h2 class="mb-3 text-xl font-semibold">Write a Review</h2>

            <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="space-y-4 rounded-lg border border-stone-200 bg-white p-4">
                @csrf

                @if ($errors->any())
                    <div class="rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="mt-1 list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="user_id" class="mb-1 block font-medium">Reviewer</label>
                    <select id="user_id" name="user_id" class="w-full rounded border border-stone-300 px-3 py-2">
                        <option value="">Choose reviewer</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rating" class="mb-1 block font-medium">Rating</label>
                    <select id="rating" name="rating" class="w-full rounded border border-stone-300 px-3 py-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ $i == 1 ? 'star' : 'stars' }}</option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="mb-1 block font-medium">Review</label>
                    <textarea id="body" name="body" rows="4" class="w-full rounded border border-stone-300 px-3 py-2">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="rounded bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">Post Review</button>
            </form>
        @else
            <p class="rounded border border-stone-200 bg-stone-100 p-4 text-stone-600">This eatery is closed. Reviews are paused.</p>
        @endif
    </div>

    {{-- Reviews, newest first --}}
    <h2 class="mb-3 text-xl font-semibold">Reviews ({{ $eatery->reviews->count() }})</h2>
    <div class="space-y-3">
        @forelse ($eatery->reviews as $review)
            <div class="rounded border border-stone-200 bg-white p-4">
                <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                    <div>
                        <a href="{{ route('reviewers.show', $review->user) }}" class="font-medium hover:text-orange-700">{{ $review->user->name }}</a>
                        <x-rating :rating="$review->rating" />
                        <span class="text-stone-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
                <p class="mt-2">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-stone-500">No reviews yet</p>
        @endforelse
    </div>
@endsection
