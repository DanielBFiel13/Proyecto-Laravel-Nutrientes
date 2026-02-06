<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminStatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/productos/crear', [ProductController::class, 'create'])->name('products.create');
    Route::post('/productos', [ProductController::class, 'store'])->name('products.store');
    Route::get('/platos', [DishController::class, 'index'])->name('dishes.index');
    Route::get('/platos/crear', [DishController::class, 'create'])->name('dishes.create');
    Route::post('/platos', [DishController::class, 'store'])->name('dishes.store');
    Route::get('/calendario', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/calendario/anadir', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/calendario', [MenuController::class, 'store'])->name('menus.store');
    Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/platos/{dish}', [DishController::class, 'destroy'])->name('dishes.destroy');
    Route::delete('/calendario/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::get('/admin/estadisticas', [AdminStatController::class, 'index'])->middleware(['auth', 'can:ver estadisticas'])->name('admin.stats');
});

require __DIR__.'/auth.php';
