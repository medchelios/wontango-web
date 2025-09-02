<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Lead capture route
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
