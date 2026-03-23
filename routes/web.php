<?php

use Illuminate\Support\Facades\Route;

// Auth Routes (Breeze)
require __DIR__.'/auth.php';

// ✅ Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});


// ✅ After Login Redirect - IMPORTANT!
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');


// ✅ User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {

    // Home
    Route::get('/dashboard', [App\Http\Controllers\User\HomeController::class, 'index'])->name('dashboard');

    // Rooms
    Route::get('/rooms', [App\Http\Controllers\User\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{id}', [App\Http\Controllers\User\RoomController::class, 'show'])->name('rooms.show');

    // Bookings
    Route::get('/bookings', [App\Http\Controllers\User\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}', [App\Http\Controllers\User\BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}', [App\Http\Controllers\User\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Reviews
    Route::post('/reviews/{id}', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('reviews.store');

    // Profile
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ✅ Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

    // Rooms
    Route::get('/rooms', [App\Http\Controllers\Admin\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [App\Http\Controllers\Admin\RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [App\Http\Controllers\Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}/edit', [App\Http\Controllers\Admin\RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [App\Http\Controllers\Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('rooms.destroy');

    // Users
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}/block', [App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block');

    // Bookings
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::put('/bookings/{id}/approve', [App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::put('/bookings/{id}/reject', [App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('bookings.reject');

    // Payments
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');

    // Reviews
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Locations
    Route::get('/locations', [App\Http\Controllers\Admin\LocationController::class, 'index'])->name('locations.index');
    Route::post('/locations', [App\Http\Controllers\Admin\LocationController::class, 'store'])->name('locations.store');
    Route::put('/locations/{id}', [App\Http\Controllers\Admin\LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{id}', [App\Http\Controllers\Admin\LocationController::class, 'destroy'])->name('locations.destroy');
});