@extends('layouts.app')

@section('content')
    <section class="mb-8">
        <h1 class="mb-2 text-3xl font-bold">Maayong pag-abot!</h1>
        <p class="text-stone-600">Find the best carinderias and eateries around Davao City.</p>
    </section>

    <h2 class="mb-4 text-xl font-semibold">Top rated eateries</h2>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>

    <p class="mt-6">
        <a href="{{ route('eateries.index') }}" class="font-medium text-orange-700 hover:underline">See all eateries →</a>
    </p>
@endsection
