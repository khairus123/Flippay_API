<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mediaId = $this->route('media')?->id;

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('media', 'title')->ignore($mediaId)],
            'type' => ['sometimes', 'required', 'string', 'max:50'],
            'genre' => ['sometimes', 'required', 'string', 'max:100'],
            'year' => ['sometimes', 'required', 'integer', 'between:1888,2100'],
            'duration' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:65535'],
        ];
    }
}
