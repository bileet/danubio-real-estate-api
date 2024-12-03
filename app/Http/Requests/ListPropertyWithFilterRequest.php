<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PropertyType;
use Illuminate\Validation\Rules\Enum;

class ListPropertyWithFilterRequest extends FormRequest
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
        $measurableRegex = '/^(>|<|=|>=|<=):\d*\.?\d*$/';

        return [
            // Property filters
            'type' => ['sometimes', 'string', new Enum(PropertyType::class)],
            'street' => 'sometimes|string|max:255',
            'size_unit' => 'sometimes|string|in:sqm,sqft',
            'size' => ['sometimes', 'string', 'regex:' . $measurableRegex],
            'bedrooms' => ['sometimes', 'string', 'regex:' . $measurableRegex],
            'price' => ['sometimes', 'string', 'regex:' . $measurableRegex],

            // Pagination
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ];
    }
}
