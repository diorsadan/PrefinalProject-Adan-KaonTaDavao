@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Edit {{ $eatery->name }}</h1>

    <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="max-w-2xl rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @method('PUT')

        @include('eateries._form')

        <div class="mt-6 flex gap-2">
            <button type="submit" class="rounded bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">Save Changes</button>
            <a href="{{ route('eateries.show', $eatery) }}" class="rounded border border-stone-300 px-4 py-2 hover:bg-stone-100">Cancel</a>
        </div>
    </form>
@endsection
