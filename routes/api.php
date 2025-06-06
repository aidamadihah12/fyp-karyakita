<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\RestController;
use App\Http\Controllers\API\VenueApiController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Example Test Route (Optional)
Route::apiResource('person', RestController::class);

// Venue Listings (Public)
Route::get('/venues', [VenueApiController::class, 'index'])->name('api.venues.index');
Route::get('/venues/{id}', [VenueApiController::class, 'show'])->name('api.venues.show');

// Authentication - Register & Login (Public)
Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');

/*
|--------------------------------------------------------------------------
| Protected API Routes (Requires Sanctum Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Authenticated User Info
    Route::get('/user', [AuthController::class, 'user'])->name('api.auth.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');

    // Booking Management
    Route::get('/bookings', [BookingController::class, 'index'])->name('api.bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('api.bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('api.bookings.show');
    Route::match(['put', 'patch'], '/bookings/{id}', [BookingController::class, 'update'])->name('api.bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('api.bookings.destroy');
});
