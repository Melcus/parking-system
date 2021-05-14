<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/token', [AuthController::class, 'token']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [UsersController::class, 'me']);
});
