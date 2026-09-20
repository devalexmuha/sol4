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
                    $this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:40960', 'dimensions:max_width=16000,max_height=16000'
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

    /**
     * Custom validation messages (covers both the image-post and echo rule sets).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Image post
            'image.required'      => 'Attach an image to publish this transmission.',
            'image.image'         => 'The file must be an image.',
            'image.mimes'         => 'Use a JPG, PNG or WebP image.',
            'image.max'           => 'Images must be 40 MB or smaller.',
            'image.dimensions'    => 'That image is too large — keep it under 16000×16000 pixels.',
            'image_title.required' => 'Give your transmission a title.',
            'image_title.string'  => 'The title must be text.',
            'image_title.max'     => 'Titles are limited to 255 characters.',

            // Echo (text post)
            'content.required'    => 'Write something before you transmit.',
            'content.string'      => 'Your echo must be text.',
            'content.min'         => 'Your echo needs at least 2 characters.',
            'content.max'         => 'Echoes are limited to 500 characters.',

            // Tags (shared)
            'tags.array'          => 'Tags were sent in an unexpected format.',
            'tags.*.integer'      => 'One of the selected tags is invalid.',
            'tags.*.exists'       => 'One of the selected tags no longer exists.',
        ];
    }
}
