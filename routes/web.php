<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Blade\RolesController;
use App\Http\Controllers\Blade\PermissionsController;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\MerchantController;
use App\Http\Controllers\Blade\ProductController;
use App\Http\Controllers\Blade\TransactionController;

Auth::routes();
Route::group(['middleware'=>"auth"],function (){

    Route::get('/', [HomeController::class,'index'])->name('home');

    // Merchants
    Route::get('/merchants', [MerchantController::class,'index'])->name('merchants.index');
    Route::get('/merchants/create', [MerchantController::class,'create'])->name('merchants.create');
    Route::get('/merchants/{id}/show', [MerchantController::class,'show'])->name('merchants.show');
    Route::post('/merchants/store', [MerchantController::class,'store'])->name('merchants.store');
    Route::get('/merchants/{id}/edit', [MerchantController::class,'edit'])->name('merchants.edit');
    Route::post('/merchants/{id}/update', [MerchantController::class,'update'])->name('merchants.update');
    Route::delete('/merchants/{id}/delete', [MerchantController::class,'delete'])->name('merchants.delete');

    // Products
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{id}/delete', [ProductController::class,'delete'])->name('products.delete');
    Route::post('/products/delete-all', [ProductController::class,'deleteAll'])->name('products.delete_all');

    Route::get('/get-product-details', 'ProductController@getProductDetails');


    // Transactions
    Route::get('/transactions', [TransactionController::class,'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class,'create'])->name('transactions.create');
    Route::post('/transactions/store', [TransactionController::class,'store'])->name('transactions.store');
    Route::get('/transactions/in', [TransactionController::class, 'income'])->name('transactions.in');
    Route::get('/transactions/out', [TransactionController::class, 'outcome'])->name('transactions.out');
    Route::post('/transactions/income', [TransactionController::class, 'incomeStore'])->name('transactions.income');
    Route::post('/transactions/outcome', [TransactionController::class, 'outcomeStore'])->name('transactions.outcome');
    Route::get('/transactions/{date}', [TransactionController::class, 'showByDate'])->name('transactions.show_by_date');
    Route::post('/transactions/delete-all', [TransactionController::class, 'deleteAll'])->name('transactions.delete_all');


    # Resources
    Route::resources([
        'permissions' => PermissionsController::class,
        'roles' => RolesController::class,
        'users' => UserController::class
    ]);
});
