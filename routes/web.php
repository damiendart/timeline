<?php

declare(strict_types=1);

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index']);
Route::redirect('/events', '/');
Route::resource('events', EventController::class)->except(['index']);
