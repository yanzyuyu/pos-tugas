<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('pos.index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('pos')->name('pos.')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('index');
    Route::get('/history', [PosController::class, 'history'])->name('history');
    Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});
