<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AgentController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\TicketAttachmentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthenticateController::class, 'index'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticateController::class, 'logout'])->name('logout');

    Route::resource('tickets', TicketController::class);

    Route::get('/ticket-attachments/{attachment}/download', [TicketAttachmentController::class, 'download'])->name('ticket-attachments.download');

    Route::post('/tickets/{ticket}/replies', [\App\Http\Controllers\TicketReplyController::class, 'store'])->name('tickets.replies.store');

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:agent'])->prefix('agent')->group(function () {
        Route::get('/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
    });

    Route::middleware(['role:customer'])->prefix('customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    });
});

