<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;
use App\Http\Controllers\Staff\VenueController as StaffVenueController;
use App\Http\Controllers\Admin\AssignmentController; // Correct import with Admin namespace

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

    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->only(['index', 'show']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('venues', AdminVenueController::class);

    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    Route::get('profit-analytics', [\App\Http\Controllers\Admin\ProfitController::class, 'index'])->name('profit.analytics');

    Route::get('system-testing', [\App\Http\Controllers\Admin\SystemTestController::class, 'index'])->name('system.testing');
    Route::post('system-testing/run', [\App\Http\Controllers\Admin\SystemTestController::class, 'runTests'])->name('system.testing.run');

    Route::get('/liveview', [\App\Http\Controllers\Admin\LiveViewController::class, 'index'])->name('liveview.index');
    Route::post('/liveview/reset', [\App\Http\Controllers\Admin\LiveViewController::class, 'reset'])->name('liveview.reset');


    // Assignment Routes using the properly imported Admin\AssignmentController
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::post('assignments/assign', [AssignmentController::class, 'assign'])->name('assignments.assign');
});


// ================= STAFF ROUTES =================

Route::middleware(['auth', 'role:Staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [StaffController::class, 'calendar'])->name('calendar');

    Route::get('/bookings', [StaffController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{id}/edit', [StaffController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{id}', [StaffController::class, 'updateBooking'])->name('bookings.update');



    Route::get('/inquiries', [StaffController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{id}', [StaffController::class, 'showInquiry'])->name('inquiries.show');

    Route::get('/notifications/send', [StaffController::class, 'notificationForm'])->name('notifications.form');
    Route::post('/notifications/send', [StaffController::class, 'sendNotification'])->name('notifications.send');

    Route::get('/live-view', [StaffController::class, 'liveView'])->name('liveview');

    Route::resource('venues', StaffVenueController::class);
});


// ================= FREELANCE ROUTES =================


Route::middleware(['auth', 'role:freelance'])->prefix('freelance')->name('freelance.')->group(function () {
    Route::get('/dashboard', [FreelanceController::class, 'dashboard'])->name('dashboard');
    Route::get('/assignments', [FreelanceController::class, 'assignments'])->name('assignments');
    Route::patch('/assignments/{id}/accept', [FreelanceController::class, 'acceptAssignment'])->name('assignments.accept');

    Route::get('/bookings', [FreelanceController::class, 'bookingsIndex'])->name('bookings.index');
    Route::get('/upload-media', [FreelanceController::class, 'uploadMediaForm'])->name('upload.media');
    Route::post('/upload-media', [FreelanceController::class, 'uploadMedia'])->name('upload.media.store');

    Route::get('/calendar', [FreelanceController::class, 'calendar'])->name('calendar');
});

