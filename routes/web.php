<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EmergencyMapController;

Route::get('/', [EmergencyMapController::class, 'index'])->name('map');
Route::post('/emergency', [EmergencyMapController::class, 'store']);


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
