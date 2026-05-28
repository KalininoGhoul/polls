<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SendCodeController;
use App\Http\Controllers\Poll\PollController;
use App\Http\Controllers\Poll\SendVoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cache.headers:public;max_age=30;etag'])->group(function () {
    Route::get('/polls', [PollController::class, 'index']);
    Route::get('/polls/{poll:slug}', [PollController::class, 'show']);
});

Route::prefix('auth')->group(function () {
    Route::post('/send-code', SendCodeController::class);
    Route::post('/login', LoginController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/polls/{poll:slug}/vote', SendVoteController::class);
});
