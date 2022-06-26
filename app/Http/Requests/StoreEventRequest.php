<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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

    /**
     * @phpstan-ignore-next-line
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'description' => '',
            'slug' => [
                'required',
                'max:255',
                Rule::unique('events'),
            ],
            'title' => 'required|string|max:255',
        ];
    }
}
