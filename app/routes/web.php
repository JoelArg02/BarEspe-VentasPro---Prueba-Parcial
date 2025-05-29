<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/create-role', [RoleController::class, 'createRol'])->name('roles.create');
        Route::get('/asignRole', [RoleController::class, 'assignRoleAdmin'])->name('roles.create.admin');

        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    });

    // Admin y Secre
    Route::middleware('role:admin|secre')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
    });

    // Bodega
    Route::middleware('role:admin|bodega')->group(function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'create', 'store', 'destroy', 'update']);
        Route::patch('categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');

        Route::resource('products', ProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });

    // Cajera
    Route::middleware('role:admin|cajera')->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);
    });
});

require __DIR__ . '/auth.php';
