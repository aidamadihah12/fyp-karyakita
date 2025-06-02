<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Protected Routes (Require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Bookings Routes
    Route::get('bookings', [BookingController::class, 'index']);  // Get all bookings
    Route::post('bookings', [BookingController::class, 'store']);  // Add a new booking
    Route::put('bookings/{id}', [BookingController::class, 'update']);  // Update a booking
    Route::delete('bookings/{id}', [BookingController::class, 'destroy']);  // Delete a booking

    // User profile route
    Route::get('user', [AuthController::class, 'user']);  // Get the authenticated user's details
});

