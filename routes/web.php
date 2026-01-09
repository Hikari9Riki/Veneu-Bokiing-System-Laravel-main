<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showlogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Authenticated Routes (Dashboard, Reservations, Profile)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/reservation', [DashboardController::class, 'reservation'])->name('dashboard.reservation');

    // Profile Routes
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/reservations/{id}/status', [UserController::class, 'updateStatus'])->name('user.reservations.update');

    // Reservation Routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index'); // List View
    Route::get('/reservations/data', [ReservationController::class, 'getReservations'])->name('reservations.getreservations'); // Calendar Data API
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create'); // Create Form
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store'); // Store Action
    
    // API Route for Venues (used in dropdowns)
    Route::get('/venues', [VenueController::class, 'getVenues'])->name('getVenues');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // The Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // The Route to handle Approve/Reject
    Route::patch('/reservations/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.reservations.update');
    // Manage Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Manage Venues (Resource Route handles index, create, store, edit, update, destroy)
    Route::resource('venues', VenueController::class);

    // Display the creation form
    Route::get('/users/create', [AuthController::class, 'showRegister'])->name('users.create');

    // Store the new user
    Route::post('/users/create', [AuthController::class, 'register'])->name('users.store');
});