<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Global search route
Route::get('/search', [SearchController::class, 'search'])->name('search')->middleware('auth');

Route::fallback(function(){
    return view('404');
});

// Patient routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('patients', PatientController::class)->except(['destroy']);
    
    // Delete requires admin role
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])
        ->name('patients.destroy')
        ->middleware('admin');

    // Appointment routes
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);

    // Doctor routes
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class);
});
