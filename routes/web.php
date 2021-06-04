<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(
    function (): void {
        Route::get('/', [EventController::class, 'index'])->name('home');
        Route::redirect('/events', '/');
        Route::resource('events', EventController::class)->except(['index']);
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    }
);

Route::middleware(['guest'])->group(
    function (): void {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    }
);
