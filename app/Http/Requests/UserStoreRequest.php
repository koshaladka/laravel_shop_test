<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|email',
            'city' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным адресом электронной почты.',
            'city.required' => 'Поле город обязательно для заполнения.',
            'city.string' => 'Поле город должно быть строкой.',
            'city.max' => 'Поле город не должно превышать 255 символов.',
        ];
    }
}
