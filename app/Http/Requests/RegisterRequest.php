<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'min:3', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required'     => 'Enter an email to create your account.',
            'email.email'        => 'Enter a valid email address.',
            'email.min'          => 'That email looks too short.',
            'email.max'          => 'That email is too long.',
            'email.unique'       => 'That email is already registered.',
            'password.required'  => 'Choose a password.',
            'password.string'    => 'Your password must be text.',
            'password.min'       => 'Your password must be at least 4 characters.',
            'password.max'       => 'That password is too long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
