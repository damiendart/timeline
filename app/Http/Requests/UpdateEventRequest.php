<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'description' => '',
            'slug' => [
                'required',
                'max:255',
                Rule::unique('events')->ignore($this->event->id),
            ],
            'title' => 'required|string|max:255',
        ];
    }
}
