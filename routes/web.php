<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
    
    // Expenses
    Route::resource('expenses', ExpenseController::class);
    
    // Income
    Route::resource('income', IncomeController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Budgets
    Route::resource('budgets', BudgetController::class);
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/monthly', [ReportController::class, 'exportMonthly'])->name('reports.export.monthly');
    Route::get('/reports/export/category', [ReportController::class, 'exportCategory'])->name('reports.export.category');
});

// Made with Bob
