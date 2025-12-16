<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'show'])->name('show');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });
    Route::middleware('auth')->group(function () { {
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        }
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
});

// Manager Routes
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:MANAGER'])->group(function () {
    Route::get('/', ManagerDashboardController::class)->name('dashboard');
});

// Staff Routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:STAFF'])->group(function () {
    Route::get('/', StaffDashboardController::class)->name('dashboard');
});
