<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ECommerce;
use App\Http\Controllers\AuthController;

// 1. Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 2. Protected Routes (Dito lahat ng may auth)
Route::middleware(['auth'])->group(function () {
    
    // Shop Routes
    Route::get('/shop', [ECommerce::class, 'index'])->name('shop');
    Route::put('/shop/{id}', [ECommerce::class, 'update'])->name('products.update');
    Route::delete('/shop/{id}', [ECommerce::class, 'destroy'])->name('products.destroy');
    
    // Admin Only: Registration Loop
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirect root to shop
Route::get('/', function () { return redirect('/shop'); });