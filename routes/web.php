<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Blade\RolesController;
use App\Http\Controllers\Blade\PermissionsController;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\MerchantController;

Auth::routes();
Route::group(['middleware'=>"auth"],function (){

    Route::get('/', [HomeController::class,'index'])->name('home');

    // Merchants
    Route::get('/merchants', [MerchantController::class,'index'])->name('merchants.index');
    Route::get('/merchants/create', [MerchantController::class,'create'])->name('merchants.create');
    Route::post('/merchants/store', [MerchantController::class,'store'])->name('merchants.store');
    Route::get('/merchants/{id}/edit', [MerchantController::class,'edit'])->name('merchants.edit');
    Route::post('/merchants/{id}/update', [MerchantController::class,'update'])->name('merchants.update');
    Route::delete('/merchants/{id}/delete', [MerchantController::class,'delete'])->name('merchants.delete');


    # Resources
    Route::resources([
        'permissions' => PermissionsController::class,
        'roles' => RolesController::class,
        'users' => UserController::class
    ]);
});
