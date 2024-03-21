<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// admin all route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // display view
    Route::get('/admin/profile', [AdminController::class, 'Profile'])->name('admin.profile');
    Route::get('/admin/transaction', [AdminController::class, 'Transaction'])->name('admin.transaction');
    Route::get('/admin/company', [AdminController::class, 'Company'])->name('admin.company');
    Route::get('/admin/outlet', [AdminController::class, 'Outlet'])->name('admin.outlet');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/users', [AdminController::class, 'Users'])->name('admin.users');
    // get product
    Route::get('/admin/products/{id}', [ProductController::class, 'edit']);
    // route for add new product
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    // route to fetch products
    Route::post('/admin/products/getProducts', [ProductController::class, 'getProducts'])->name('admin.products.getProducts');
    // profile
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
