<?php

// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected array $fakeUserData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'pXGnUJ3qN4',
        'password_confirmation' => 'pXGnUJ3qN4',
    ];

    public function testUnauthenticatedUsersCanGetToRegistrationScreen(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testUnauthenticatedUsersCanRegister(): void
    {
        Event::fake();

        $response = $this->post('/register', $this->fakeUserData);

        Event::assertDispatched(Registered::class);
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUsersCannotGetToRegistrationScreen(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testAuthenticatedUsersCannotRegister(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/register', $this->fakeUserData);

        $this->assertNull(User::where('email', $this->fakeUserData['email'])->first());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
