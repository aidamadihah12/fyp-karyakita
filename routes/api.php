<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\RestController;
use App\Http\Controllers\API\VenueApiController;

// ========== Resource Test Route (Optional) ==========
Route::resource('person', RestController::class);

// ========== Public: Venue Listing ==========
Route::get('/venues', [VenueApiController::class, 'index']);       // List venues with optional filters
Route::get('/venues/{id}', [VenueApiController::class, 'show']);   // Show venue by ID
Route::get('/venues', [VenueApiController::class, 'index']);

// ========== Public: Authentication ==========
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ========== Protected Routes ==========
Route::middleware('auth:sanctum')->group(function () {

    // Bookings CRUD
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    // Authenticated user profile
    Route::get('/user', [AuthController::class, 'user']);
});
