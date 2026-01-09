<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/calendar', [HomepageController::class, 'calendar'])->name('calendar');
Route::get('/venues', [VenueController::class, 'getVenues'])->name('getVenues');
Route::get('/reservations', [ReservationController::class, 'getReservations'])->name('reservations.getreservations');




// Only guests can see the login page
Route::get('/register', [AuthController::class, 'showRegister'])->name('showregister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'showLogout'])->name('showlogout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Only authenticated users can see this
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Reservation Routes
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::patch('/reservations/{id}/status', [UserController::class, 'updateStatus'])->name('user.reservations.update');
});

use App\Http\Controllers\AdminController;

// Group these under 'auth' and preferably 'admin' middleware
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // The Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // The Route to handle Approve/Reject
    Route::patch('/reservations/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.reservations.update');
});
