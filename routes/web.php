<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware(['throttle:5,1'])
    ->name('leads.store');