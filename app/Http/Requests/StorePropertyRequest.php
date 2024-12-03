<?php

namespace App\Http\Requests;

use App\Enums\PropertyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', new Enum(PropertyType::class)],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'size' => 'required|integer|min:1',
            'size_unit' => 'required|string|in:sqm,sqft',
            'bedrooms' => 'required|integer|min:1',
            'price' => 'required|decimal:0,2',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.latitude' => 'required|numeric|min:-90|max:90',
            'address.longitude' => 'required|numeric|min:-180|max:180',
        ];
    }
}
