<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\RestController;
use App\Http\Controllers\API\VenueApiController;


// Public API Routes


// Example/Test Resource API (optional)
Route::apiResource('person', RestController::class);

// Venue Listings (Supports optional filters: ?location=&date=&package_type=&event_type=)
Route::get('/venues', [VenueApiController::class, 'index'])->name('api.venues.index');
Route::get('/venues/{id}', [VenueApiController::class, 'show'])->name('api.venues.show');

//  User Registration and Login
Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');

// ===========================
// Protected API Routes (Require Auth via Sanctum Token)
// ===========================
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');

    // Get Authenticated User Info
    Route::get('/user', [AuthController::class, 'user'])->name('api.auth.user');

    // Booking Management
    Route::get('/bookings', [BookingController::class, 'index'])->name('api.bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('api.bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('api.bookings.show'); // Optional

    Route::match(['put', 'patch'], '/bookings/{id}', [BookingController::class, 'update'])->name('api.bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('api.bookings.destroy');
});
