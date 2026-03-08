<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

/*
| Events
*/

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);

/*
| Attendees
*/

Route::get('/events/{id}/attendees/create', [AttendeeController::class, 'create']);
Route::post('/events/{id}/attendees', [AttendeeController::class, 'store']);

/*
| Clients
*/

Route::get('/clients', [ClientController::class,'index']);
Route::get('/clients/create', [ClientController::class,'create']);
Route::post('/clients', [ClientController::class,'store']);