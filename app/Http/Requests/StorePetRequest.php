<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->pets()->count() < 5;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'breed' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0', 'max:30'],
            'gender' => ['required', 'boolean'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['required', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Please upload a photo of your pet.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'The image may not be greater than 5MB.',
        ];
    }
}
