<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\AdminController;

// Admin sub-controllers
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfitController;
use App\Http\Controllers\Admin\SystemTestController;
use App\Http\Controllers\Admin\LiveViewController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;

// Staff venue controller
use App\Http\Controllers\Staff\VenueController as StaffVenueController;

// ================= PUBLIC & AUTH ROUTES =================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Password Reset Routes
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// ================= ADMIN ROUTES =================
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [AdminController::class, 'calendar'])->name('calendar');

    // Resources
    Route::resource('events', EventController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    Route::resource('users', UserController::class);
    Route::resource('venues', AdminVenueController::class)->except(['show']);

    // Reports, Profit, System Testing
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('profit-analytics', [ProfitController::class, 'index'])->name('profit.analytics');
    Route::get('system-testing', [SystemTestController::class, 'index'])->name('system.testing');
    Route::post('system-testing/run', [SystemTestController::class, 'runTests'])->name('system.testing.run');

    // Live view
    Route::get('/liveview', [LiveViewController::class, 'index'])->name('liveview.index');
    Route::post('/liveview/reset', [LiveViewController::class, 'reset'])->name('liveview.reset');
});


// ================= STAFF ROUTES =================
Route::middleware(['auth', 'role:Staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [StaffController::class, 'calendar'])->name('calendar');

    // Bookings
    Route::get('/bookings', [StaffController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{id}/edit', [StaffController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{id}', [StaffController::class, 'updateBooking'])->name('bookings.update');

    // Inquiries
    Route::get('/inquiries', [StaffController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{id}', [StaffController::class, 'showInquiry'])->name('inquiries.show');

    // Notifications
    Route::get('/notifications/send', [StaffController::class, 'notificationForm'])->name('notifications.form');
    Route::post('/notifications/send', [StaffController::class, 'sendNotification'])->name('notifications.send');

    // Live view
    Route::get('/live-view', [StaffController::class, 'liveView'])->name('liveview');

    // Venue (read and edit only)
    Route::get('/venues', [StaffVenueController::class, 'index'])->name('venues.index');
    Route::get('/venues/{id}/edit', [StaffVenueController::class, 'edit'])->name('venues.edit');
    Route::put('/venues/{id}', [StaffVenueController::class, 'update'])->name('venues.update');
});


// ================= FREELANCE ROUTES =================
Route::middleware(['auth', 'role:Freelance'])->prefix('freelance')->name('freelance.')->group(function () {
    Route::get('/dashboard', [FreelanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [FreelanceController::class, 'calendar'])->name('calendar');

    // Media upload
    Route::post('freelance/upload-media', [FreelanceController::class, 'uploadMedia'])->name('freelance.upload.media');
    Route::get('/upload-media', [FreelanceController::class, 'uploadMediaForm'])->name('upload.media.form');
    Route::post('/upload-media', [FreelanceController::class, 'uploadMedia'])->name('upload.media');

    // Availability
    Route::get('/availability/edit', [FreelanceController::class, 'editAvailability'])->name('availability.edit');
    Route::post('/availability/update', [FreelanceController::class, 'updateAvailability'])->name('availability.update');

    // Assignments
    Route::get('/assignments', [FreelanceController::class, 'assignments'])->name('assignments');
    Route::post('/assignments/{id}/accept', [FreelanceController::class, 'acceptAssignment'])->name('assignments.accept');
});
