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
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,JPG,gif,webp,avif', 'max:2048'],
            'user_bio'=> ['nullable', 'string', 'min:2', 'max:500'],
        ];
    }
}

// Rule::unique('user_profiles', 'user_name')
//                ->ignore($this->route('userProfile')), check this one.
