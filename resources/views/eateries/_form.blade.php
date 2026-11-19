{{-- Shared by create and edit. $eatery only exists on the edit page. --}}
@php
    $eatery = $eatery ?? null;

    // after a failed submit use what was ticked; otherwise the saved features (edit) or none (create)
    $checkedFeatures = old('features', $errors->any() ? [] : ($eatery ? $eatery->features->pluck('id')->all() : []));
@endphp

@if ($errors->any())
    <div class="mb-6 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
        <p class="font-semibold">Please fix the following:</p>
        <ul class="mt-1 list-disc pl-5 text-sm">
            {{-- array_unique: name and slug can fail with the same message --}}
            @foreach (array_unique($errors->all()) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label for="name" class="mb-1 block font-medium">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $eatery?->name) }}" class="w-full rounded border border-stone-300 px-3 py-2">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        {{-- the slug is made from the name, so its error belongs here; skip it if name already has an error --}}
        @error('slug')
            @unless ($errors->has('name'))
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @endunless
        @enderror
    </div>

    <div>
        <label for="district_id" class="mb-1 block font-medium">District</label>
        <select id="district_id" name="district_id" class="w-full rounded border border-stone-300 px-3 py-2">
            <option value="">Choose district</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $eatery?->district_id) == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="address" class="mb-1 block font-medium">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address', $eatery?->address) }}" class="w-full rounded border border-stone-300 px-3 py-2">
        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price_range" class="mb-1 block font-medium">Price range</label>
        <select id="price_range" name="price_range" class="w-full rounded border border-stone-300 px-3 py-2">
            <option value="">Choose price range</option>
            <option value="budget" @selected(old('price_range', $eatery?->price_range) == 'budget')>Budget (₱)</option>
            <option value="mid" @selected(old('price_range', $eatery?->price_range) == 'mid')>Mid (₱₱)</option>
            <option value="splurge" @selected(old('price_range', $eatery?->price_range) == 'splurge')>Splurge (₱₱₱)</option>
        </select>
        @error('price_range')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="specialty" class="mb-1 block font-medium">Specialty <span class="text-sm font-normal text-stone-500">(optional)</span></label>
        <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $eatery?->specialty) }}" class="w-full rounded border border-stone-300 px-3 py-2">
        @error('specialty')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{-- hidden 0 is sent when the box is unchecked; a checked box sends 1 and overrides it --}}
        <input type="hidden" name="is_open" value="0">
        <label class="inline-flex items-center gap-2 font-medium">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery ? $eatery->is_open : true))>
            Open
        </label>
        @error('is_open')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <fieldset>
        <legend class="mb-1 font-medium">Features</legend>
        <div class="flex flex-wrap gap-4">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $checkedFeatures))>
                    {{ $feature->name }}
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('features.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </fieldset>

    <div>
        <label for="permit_no" class="mb-1 block font-medium">Permit number</label>
        <input type="text" id="permit_no" name="permit_no" value="{{ old('permit_no', $eatery?->permit?->permit_no) }}" placeholder="DVO-2026-0415" class="w-full rounded border border-stone-300 px-3 py-2">
        @error('permit_no')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="expires_on" class="mb-1 block font-medium">Permit expires on</label>
        <input type="date" id="expires_on" name="expires_on" value="{{ old('expires_on', $eatery?->permit?->expires_on?->format('Y-m-d')) }}" class="w-full rounded border border-stone-300 px-3 py-2">
        @error('expires_on')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
