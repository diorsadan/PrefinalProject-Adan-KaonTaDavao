@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Districts</h1>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}" class="rounded-lg border border-stone-200 bg-white p-4 shadow-sm hover:border-orange-400">
                <span class="text-lg font-semibold">{{ $district->name }}</span>
                <span class="block text-sm text-stone-600">{{ $district->eateries_count }} {{ $district->eateries_count == 1 ? 'eatery' : 'eateries' }}</span>
            </a>
        @endforeach
    </div>
@endsection
