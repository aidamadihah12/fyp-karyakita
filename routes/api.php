<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\RestController;
use App\Models\Venue;
use App\Http\Controllers\API\VenueApiController;



// ========== Resource Test Route (Optional) ==========
Route::resource('person', RestController::class);
Route::get('/events', [VenueApiController::class, 'index']);

// ========== Public: Venue Listing ==========
Route::get('/events', function (Request $request) {
    $venues = Venue::query()
        ->when($request->location, fn($q) => $q->where('location', 'like', '%' . $request->location . '%'))
        ->when($request->package_type, fn($q) => $q->where('package_type', $request->package_type))
        ->when($request->event_type, fn($q) => $q->where('event_type', $request->event_type))
        ->when($request->date, fn($q) => $q->whereDate('available_date', $request->date))
        ->get();

    return response()->json([
        'status' => 'success',
        'count' => $venues->count(),
        'data' => $venues
    ]);
});

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
