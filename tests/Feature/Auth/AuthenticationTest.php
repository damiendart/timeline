<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedUsersCanGetToLoginScreen(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUnauthenticatedUsersCanAuthenticateWithValidCredentials(): void
    {
        $user = User::factory()->create();
        $response = $this->post(
            '/login',
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUnauthenticatedUsersCannotAuthenticateWithInvalidCredentials(): void
    {
        $user = User::factory()->create();

        $this->post(
            '/login',
            [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]
        );
        $this->assertGuest();
    }

    public function testAuthenticatedUsersCannotGetToLoginScreen(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
