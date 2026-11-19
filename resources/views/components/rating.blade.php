@props(['rating'])

@php
    // round to a whole number of stars, kept between 0 and 5
    $filled = max(0, min(5, (int) round($rating ?? 0)));
@endphp

<span class="text-amber-500" title="{{ $filled }} out of 5">{{ str_repeat('★', $filled) }}{{ str_repeat('☆', 5 - $filled) }}</span>
