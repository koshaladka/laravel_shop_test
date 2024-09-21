<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRentRequest extends FormRequest
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
            'id' => 'required|exists:products,id',
            'duration' => 'required|in:4,8,12,24',
        ];
    }

    public function messages(): array
    {
        return [
            'duration.in' => 'The duration must be one of the following values: 4, 8, 12, 24.',
        ];
    }
}
