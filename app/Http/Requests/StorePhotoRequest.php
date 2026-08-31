<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'alt' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['required', 'image', 'max:5120'],
        ];
    }
}
