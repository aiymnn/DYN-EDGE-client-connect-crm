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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('interactions', InteractionController::class);
Route::get('/interactions/search-customers', [InteractionController::class, 'searchCustomers']);

//export csv & pdf
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/staffs/export', [ReportController::class, 'exportStaffs'])->name('reports.staffs.export');
Route::get('/reports/customers/export', [ReportController::class, 'exportCustomers'])->name('reports.customers.export');
Route::get('/reports/tickets/export', [ReportController::class, 'exportTickets'])->name('reports.tickets.export');
Route::get('/reports/interactions/export', [ReportController::class, 'exportInteractions'])->name('reports.interactions.export');

Route::resource('tickets', TicketController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
