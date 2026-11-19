<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaon Ta! Davao – Adan's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 text-stone-800">
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex max-w-5xl flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-orange-700">Kaon Ta! Davao – Adan's Food Guide</a>
            @include('partials.nav')
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @include('partials.flash')

        @yield('content')
    </main>
</body>
</html>
