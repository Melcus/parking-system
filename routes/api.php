<?php

use App\Http\Controllers\Api\GarageController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\SpotController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/token', [LoginController::class, 'token']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::patch('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy']);
});

Route::middleware(['internal'])->group(function () {
    Route::get('garages', [GarageController::class, 'index']);
    Route::get('garages/{garage}/spots', [SpotController::class, 'index']);
});
