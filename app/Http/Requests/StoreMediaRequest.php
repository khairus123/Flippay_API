<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('media', 'title')],
            'type' => ['required', 'string', 'max:50'],
            'genre' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'between:1888,2100'],
            'duration' => ['nullable', 'integer', 'min:1', 'max:65535'],
        ];
    }
}
