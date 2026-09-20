<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => [
                'required', 'string', 'min:2', 'max:255',
                Rule::unique('user_profiles', 'user_name')
                    ->ignore($this->route('userProfile')),
                'regex:/^[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*$/'
            ],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,JPG,gif,webp,avif', 'max:40960'],
            'user_bio'=> ['nullable', 'string', 'min:2', 'max:500'],
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
            'user_name.required' => 'Choose a user name.',
            'user_name.string'   => 'Your user name must be text.',
            'user_name.min'      => 'User names need at least 2 characters.',
            'user_name.max'      => 'User names are limited to 255 characters.',
            'user_name.unique'   => 'That user name is already taken.',
            'user_name.regex'    => 'Use letters and numbers, with single . _ or - between them.',

            'logo.image'         => 'Your avatar must be an image.',
            'logo.mimes'         => 'Use a JPG, PNG, GIF, WebP or AVIF image.',
            'logo.max'           => 'Avatars must be 40 MB or smaller.',

            'user_bio.string'    => 'Your bio must be text.',
            'user_bio.min'       => 'Your bio needs at least 2 characters.',
            'user_bio.max'       => 'Bios are limited to 500 characters.',
        ];
    }
}
