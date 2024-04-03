<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// admin all route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    // display view
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    Route::get('/admin/warehouse', [WarehouseController::class, 'index'])->name('admin.warehouse');
    Route::get('/admin/withdrawal', [WithdrawalController::class, 'index'])->name('admin.withdrawal');
    Route::get('/admin/companies', [CompanyController::class, 'index'])->name('admin.companies');
    Route::get('/admin/outlets', [OutletController::class, 'index'])->name('admin.outlets');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/users', [AdminController::class, 'Users'])->name('admin.users');
    // get product/outlet/stocks/unit_price/transactions
    Route::get('/admin/products/{id}', [ProductController::class, 'edit']);
    Route::get('/admin/outlets/{id}', [OutletController::class, 'edit']);
    Route::get('/admin/warehouse/{id}', [WarehouseController::class, 'edit']);
    Route::get('/get-outlet-name-address/{id}', [OutletController::class, 'getOutletNameAddress']);
    Route::get('/get-outlet-name/{id}', [OutletController::class, 'getOutletName']);
    Route::get('/get-unit-price-and-description/{id}', [ProductController::class, 'getUnitPriceAndDescription']);
    Route::get('/get-transaction-number', [TransactionController::class, 'getTransactionNumber']);
    // route for add new product/outlets/stocks/transactions
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/outlets', [OutletController::class, 'store'])->name('admin.outlets.store');
    Route::post('/admin/warehouse', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
    Route::post('/admin/transactions', [TransactionController::class, 'store'])->name('admin.transactions.store');
    // update existing products/outlets/stocks/onhand
    Route::put('/admin/products/{id}', [ProductController::class, 'update']);
    Route::put('/admin/outlets/{id}', [OutletController::class, 'update']);
    Route::put('/admin/warehouse/{id}', [WarehouseController::class, 'update']);
    Route::put('/admin/transactions/{id}', [TransactionController::class, 'update']);
    // route to fetch products/outlets/stocks/transactions
    Route::post('/admin/products/getProducts', [ProductController::class, 'getProducts'])->name('admin.products.getProducts');
    Route::post('/admin/outlets/getOutlets', [OutletController::class, 'getOutlets'])->name('admin.outlets.getOutlets');
    Route::post('/admin/warehouse/getStocks', [WarehouseController::class, 'getStocks'])->name('admin.warehouse.getStocks');
    Route::post('/admin/transactions/getTransactions', [TransactionController::class, 'getTransactions'])->name('admin.transactions.getTransactions');
    // delete product/outlet
    Route::delete('/admin/products/{id}', [ProductController::class, 'delete']);
    Route::delete('/admin/outlets/{id}', [OutletController::class, 'delete']);
    Route::delete('/admin/warehouse/{id}', [WarehouseController::class, 'delete']);
    // profile
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('/admin/products/', 'ProductController');
});

require __DIR__ . '/auth.php';
