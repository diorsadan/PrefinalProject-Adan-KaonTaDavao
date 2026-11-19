@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Eateries</h1>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @empty
            <p class="text-stone-500">No eateries found.</p>
        @endforelse
    </div>
@endsection
