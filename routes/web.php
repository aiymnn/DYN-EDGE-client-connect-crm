<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// AJAX api
// Route::get('/staffs/search', [UserController::class, 'search'])->name('staffs.search');
// Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staffs
    Route::resource('users', UserController::class);
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');

    // Customers
    Route::resource('customers', CustomerController::class);
    Route::post('customers/{customer}/restore', [CustomerController::class, 'restore'])->name('customers.restore');

    // Interactions
    Route::resource('interactions', InteractionController::class);

    // Tickets
    Route::resource('tickets', TicketController::class);

    // Export CSV & PDF
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/staffs/export', [ReportController::class, 'exportStaffs'])->name('reports.staffs.export');
    Route::get('/reports/customers/export', [ReportController::class, 'exportCustomers'])->name('reports.customers.export');
    Route::get('/reports/tickets/export', [ReportController::class, 'exportTickets'])->name('reports.tickets.export');
    Route::get('/reports/interactions/export', [ReportController::class, 'exportInteractions'])->name('reports.interactions.export');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
