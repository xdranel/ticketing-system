<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AgentController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthenticateController::class, 'index'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticateController::class, 'logout'])->name('logout');

    // Dashboard User Routes
    // Customer
    Route::get('/dashboard', [CustomerController::class, 'index'])->middleware('role:customer')
        ->name('dashboard');

    // Agent
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->middleware('role:agent')
        ->name('agent.dashboard');

    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('role:admin')
        ->name('admin.dashboard');
});

