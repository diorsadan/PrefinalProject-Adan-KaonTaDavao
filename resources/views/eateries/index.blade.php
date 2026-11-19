@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Eateries</h1>

    {{-- GET form: the filters go into the URL, e.g. /eateries?q=tinola&district=1 --}}
    <form method="GET" action="{{ route('eateries.index') }}" class="mb-6 grid grid-cols-1 gap-3 rounded-lg border border-stone-200 bg-white p-4 md:grid-cols-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty"
               class="rounded border border-stone-300 px-3 py-2">

        <select name="district" class="rounded border border-stone-300 px-3 py-2">
            <option value="">All districts</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(request('district') == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>

        <select name="feature" class="rounded border border-stone-300 px-3 py-2">
            <option value="">All features</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->name }}" @selected(request('feature') == $feature->name)>{{ $feature->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">Filter</button>
            <a href="{{ route('eateries.index') }}" class="rounded border border-stone-300 px-4 py-2 text-center hover:bg-stone-100">Clear</a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <p class="text-stone-500">No eateries match your filters.</p>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif

    <div class="mt-6">
        {{ $eateries->links() }}
    </div>
@endsection
