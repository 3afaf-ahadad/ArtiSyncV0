<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated routes group
Route::middleware(['auth'])->group(function () {
    // Dashboard (custom ArtiSync controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Machine management (CRUD without index)
    Route::resource('machines', MachineController::class)->except(['index']);

    // Maintenance store
    Route::post('/machines/{machine}/maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');

    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes (login, register, logout, etc.)
require __DIR__.'/auth.php';