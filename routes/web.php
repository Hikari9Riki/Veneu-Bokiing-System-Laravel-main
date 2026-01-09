<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('showregister');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showlogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Authenticated Routes (Dashboard, Reservations, Profile)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Reservation Routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index'); // List View
    Route::get('/reservations/data', [ReservationController::class, 'getReservations'])->name('reservations.getreservations'); // Calendar Data API
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create'); // Create Form
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store'); // Store Action
    
    // API Route for Venues (used in dropdowns)
    Route::get('/venues', [VenueController::class, 'getVenues'])->name('getVenues');
});