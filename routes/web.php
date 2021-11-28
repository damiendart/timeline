<?php

// Copyright (C) 2021 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(
    function (): void {
        Route::get('/', [EventController::class, 'index'])->name('home');
        Route::redirect('/events', '/');
        Route::resource('events', EventController::class)->except(['index']);

        Route::get('/logout', [AuthenticatedSessionController::class, 'edit'])
            ->name('logout');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    }
);

Route::middleware(['guest'])->group(
    function (): void {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);
    }
);
