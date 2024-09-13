<?php

namespace App\Http\Requests;

use App\Rules\InArrayValues;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|string',
            'lastname' => 'required|string',
            'roles' => [
                'required',
                new InArrayValues
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'password' => 'required|string|confirmed'
        ];
    }
}
