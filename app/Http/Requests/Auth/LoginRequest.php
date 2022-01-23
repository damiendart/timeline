<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (
            !Auth::attempt(
                $this->only('email', 'password'),
                $this->boolean('remember'),
            )
        ) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages(
                [
                    'email' => __('auth.failed'),
                ],
            );
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages(
            [
                'email' => trans(
                    'auth.throttle',
                    [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60),
                    ],
                ),
            ],
        );
    }

    public function throttleKey(): string
    {
        return Str::lower($this->ip());
    }
}
