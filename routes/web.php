<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialRecordController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (authenticated only)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard (all authenticated, active users)
Route::middleware(['role:viewer,analyst,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Financial Records
Route::middleware(['role:viewer,analyst,admin'])->group(function () {
    Route::get('/records', [FinancialRecordController::class, 'index'])->name('records.index');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/records/create', [FinancialRecordController::class, 'create'])->name('records.create');
    Route::post('/records', [FinancialRecordController::class, 'store'])->name('records.store');
    Route::get('/records/{record}/edit', [FinancialRecordController::class, 'edit'])->name('records.edit');
    Route::put('/records/{record}', [FinancialRecordController::class, 'update'])->name('records.update');
    Route::delete('/records/{record}', [FinancialRecordController::class, 'destroy'])->name('records.destroy');
});

// User Management (admin only)
Route::middleware(['role:admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
