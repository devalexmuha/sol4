<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->is('sol', 'sol/*') ?
            [
                'image' => [
                    $this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096', 'dimensions:max_width=8000,max_height=8000'
                ],
                'image_title' => ['required', 'string', 'max:255'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['integer', 'exists:tags,id'],
            ]
            :
            [
                'content' => ['required', 'string', 'min:2', 'max:500'],
                'tags' => ['nullable', 'array'],
                'tags.*' => ['integer', 'exists:tags,id'],
            ];

    }
}
