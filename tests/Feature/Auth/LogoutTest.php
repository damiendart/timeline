<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUsersCanGetToLogoutScreen(): void
    {
        $response = $this
            ->actingAs(User::factory()->create())
            ->get('/logout');

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function testAuthenticatedUsersCanLogout(): void
    {
        $response = $this
            ->actingAs(User::factory()->create())
            ->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function testUnauthenticatedUsersCannotGetToLogoutScreen(): void
    {
        $response = $this->get('/logout');

        $response->assertRedirect('/login');
    }

    public function testUnauthenticatedUsersCannotLogout(): void
    {
        $response = $this->post('/logout');

        $response->assertRedirect('/login');
    }
}
