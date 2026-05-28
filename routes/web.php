<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoriesController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrdersController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/login-process', [AuthController::class, 'loginProcess'])
    ->name('login.process');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('area', AreaController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('item-categories', ItemCategoriesController::class);
    Route::resource('items', ItemController::class);
    Route::resource('sales-orders', SalesOrdersController::class);

});