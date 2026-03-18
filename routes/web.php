<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clients', ClientController::class);

    Route::resource('events', EventController::class);

    Route::resource('vendors', VendorController::class);

    Route::resource('users', UserController::class);

    Route::get('/services/create/{event}', [ServiceController::class, 'create'])->name('services.create');

    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

    Route::get('/attendees/create/{event}', [AttendeeController::class, 'create'])->name('attendees.create');

    Route::post('/attendees', [AttendeeController::class, 'store'])->name('attendees.store');

});

require __DIR__.'/auth.php';