<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware(['throttle:5,1'])
    ->name('leads.store');
