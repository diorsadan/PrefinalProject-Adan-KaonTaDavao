<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateEateryRequest extends FormRequest
{
    /**
     * Make the slug before validating, so it can be checked for uniqueness too.
     * (string) turns an empty name (null) into '' so Str::slug() does not crash.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) $this->name),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Same as StoreEateryRequest, but name and permit_no ignore this eatery's own rows,
     * so saving an eatery without changes does not fail the unique check.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('eateries', 'name')->ignore($this->route('eatery')->id)],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['required', 'string', 'max:255'],
            'price_range' => ['required', 'in:budget,mid,splurge'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'is_open' => ['boolean'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['exists:features,id'],
            'permit_no' => ['required', 'regex:/^DVO-\d{4}-\d{4,5}$/', Rule::unique('permits', 'permit_no')->ignore($this->route('eatery')->permit?->id)],
            'expires_on' => ['required', 'date', 'after:today'],
            'slug' => [Rule::unique('eateries', 'slug')->ignore($this->route('eatery')->id)],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Kaon Ta Adan already lists an eatery with this name.',
            'features.required' => 'Pick at least one feature.',
            'features.min' => 'Pick at least one feature.',
            'permit_no.regex' => 'Permit number must look like DVO-2026-0415.',
            'expires_on.after' => 'The permit must not be expired.',
            'slug.unique' => 'Kaon Ta Adan already lists an eatery with this name.',
        ];
    }
}
