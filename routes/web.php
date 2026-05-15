<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EcommerceController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/inventory/report', [EcommerceController::class, 'generatePDF'])->name('inventory.report');

Route::put('/update-qty/{id}', [EcommerceController::class, 'update'])->name('products.update');


Route::middleware(['auth'])->group(function () {
    
    // Shop Routes
    Route::get('/shop', [ECommerceController::class, 'index'])->name('shop');
    Route::put('/shop/{id}', [ECommerceController::class, 'update'])->name('products.update');
    Route::delete('/shop/{id}', [ECommerceController::class, 'destroy'])->name('products.destroy');
    
    // Admin Only: Registration Loop
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirect root to shop
Route::get('/', function () { return redirect('/shop'); });