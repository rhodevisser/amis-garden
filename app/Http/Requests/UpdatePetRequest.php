<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('pet')->user_id;
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
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
