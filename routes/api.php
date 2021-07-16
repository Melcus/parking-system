<?php

use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\GarageController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\SpotController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/token', [LoginController::class, 'token']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::get('reservations/{reservation:uuid}', [ReservationController::class, 'show']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::patch('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy']);
    Route::post('/calculate-payment', PaymentController::class);
    Route::get('checkout/{reservation}', [CheckoutController::class, 'show']);
});

Route::middleware(['internal'])->group(function () {
    Route::get('garages', [GarageController::class, 'index']);
    Route::get('garages/{garage}', [GarageController::class, 'show']);
    Route::get('garages/{garage}/spots', [SpotController::class, 'index']);
});
