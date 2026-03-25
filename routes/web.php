<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\VendorPortalController;

/*
|--------------------------------------------------------------------------
| WEMS - Waridi Events Management System
| Final Year Project | BBIT 04205
| Author: Muswii Collins Mutuku | Reg: 22/05989
| Supervisor: Gladys Mange
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes (Laravel Breeze)
Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ALL AUTHENTICATED USERS
Route::middleware(['auth'])->group(function () {
    
    // Role-based dashboard redirect
    Route::get('/home', function() {
        $role = Auth::user()->role;
        
        return match($role) {
            'client' => redirect()->route('client.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            default => redirect()->route('dashboard'),
        };
    })->name('home');
});

// ADMIN, MANAGER, STAFF ONLY (Full System Access)
Route::middleware(['auth', 'role:admin|manager|staff'])->group(function () {
    
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Full CRUD Access
    Route::resource('clients', ClientController::class);
    Route::resource('events', EventController::class);
    Route::resource('vendors', VendorController::class);
    
    // Services Management
    Route::get('/events/{event}/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/events/{event}/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    
    // Attendees Management
    Route::get('/events/{event}/attendees/create', [AttendeeController::class, 'create'])->name('attendees.create');
    Route::post('/events/{event}/attendees', [AttendeeController::class, 'store'])->name('attendees.store');
    Route::delete('/attendees/{attendee}', [AttendeeController::class, 'destroy'])->name('attendees.destroy');
});

// ADMIN & MANAGER ONLY (User Management)
Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::resource('users', UserController::class);
});

// CLIENT ONLY (Restricted Portal)
Route::middleware(['auth', 'role:client'])->prefix('my-account')->name('client.')->group(function () {
    Route::get('/', [ClientPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [ClientPortalController::class, 'events'])->name('events');
    Route::get('/events/{event}', [ClientPortalController::class, 'showEvent'])->name('events.show');
});

// VENDOR ONLY (Restricted Portal)
Route::middleware(['auth', 'role:vendor'])->prefix('vendor-portal')->name('vendor.')->group(function () {
    Route::get('/', [VendorPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [VendorPortalController::class, 'bookings'])->name('bookings');
});