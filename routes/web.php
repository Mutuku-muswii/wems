<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\VendorPortalController;
use App\Http\Controllers\ProfileController;

// Public - redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        $role = auth()->user()->role;
        return match($role) {
            'client' => redirect()->route('portal.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
    return redirect()->route('login');
});

// Auth routes (Login, Register, etc.)
require __DIR__.'/auth.php';

// ALL AUTHENTICATED USERS
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN, MANAGER, STAFF (Internal Team)
Route::middleware(['auth', 'role:admin|manager|staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('clients', ClientController::class);
    Route::resource('events', EventController::class);
    
    // Services Management
    Route::get('/events/{event}/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/events/{event}/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    
    // Attendees Management (Internal)
    Route::get('/events/{event}/attendees/create', [AttendeeController::class, 'create'])->name('attendees.create');
    Route::post('/events/{event}/attendees', [AttendeeController::class, 'store'])->name('attendees.store');
    Route::get('/attendees/{attendee}/edit', [AttendeeController::class, 'edit'])->name('attendees.edit');
    Route::put('/attendees/{attendee}', [AttendeeController::class, 'update'])->name('attendees.update');
    Route::delete('/attendees/{attendee}', [AttendeeController::class, 'destroy'])->name('attendees.destroy');
});

// ADMIN & MANAGER ONLY
Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::resource('vendors', VendorController::class);
    Route::resource('users', UserController::class);
});

// ADMIN ONLY
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/reports', [DashboardController::class, 'reports'])->name('admin.reports');
});

// CLIENT PORTAL (My Account)
Route::middleware(['auth', 'role:client'])->prefix('my-account')->name('portal.')->group(function () {
    Route::get('/', [ClientPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [ClientPortalController::class, 'events'])->name('events');
    Route::get('/events/{event}', [ClientPortalController::class, 'eventDetails'])->name('events.show');
    
    // Client-side Attendee Management (Matches event-details.blade.php)
    Route::post('/events/{event}/attendees/add', [ClientPortalController::class, 'addAttendee'])->name('events.attendees.add');
    Route::post('/events/{event}/attendees/upload', [ClientPortalController::class, 'uploadAttendees'])->name('events.attendees.upload');
    Route::delete('/events/{event}/attendees/{attendee}', [ClientPortalController::class, 'deleteAttendee'])->name('events.attendees.delete');
    
    Route::get('/invoices', [ClientPortalController::class, 'invoices'])->name('invoices');
    Route::post('/events/{event}/approve', [ClientPortalController::class, 'approveEvent'])->name('events.approve');
});

// VENDOR PORTAL
Route::middleware(['auth', 'role:vendor'])->prefix('vendor-dashboard')->name('vendor.')->group(function () {
    Route::get('/', [VendorPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [VendorPortalController::class, 'events'])->name('events');
    Route::get('/events/{event}', [VendorPortalController::class, 'eventDetails'])->name('events.show');
    Route::get('/reviews', [VendorPortalController::class, 'myReviews'])->name('reviews');
});

// ATTENDEE PUBLIC ACCESS (RSVP System)
Route::get('/invitation/{token}', [AttendeeController::class, 'publicView'])->name('attendees.public');
Route::post('/invitation/{token}/rsvp', [AttendeeController::class, 'rsvp'])->name('attendees.rsvp');