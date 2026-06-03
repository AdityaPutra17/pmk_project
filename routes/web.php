<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCategoriesController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrdersController;
use App\Http\Controllers\DeliveryOrdersController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/login-process', [AuthController::class, 'loginProcess'])
    ->name('login.process');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('area', AreaController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('item-categories', ItemCategoriesController::class);
    Route::resource('items', ItemController::class);
    Route::resource('sales-orders', SalesOrdersController::class);
    Route::resource('delivery-orders', DeliveryOrdersController::class);

    Route::resource('invoice', InvoiceController::class);

    Route::get(
        '/invoice/generate/{id}',
        [InvoiceController::class, 'generate']
    )->name('invoice.generate');

    
    Route::get(
        '/delivery-orders/print/{id}',
        [DeliveryOrdersController::class, 'print']
        )->name('delivery-orders.print');
        
    Route::get(
        '/invoice/print/{id}',
        [InvoiceController::class, 'print']
    )->name('invoice.print');

    Route::get(
    '/invoice/create',
    [InvoiceController::class,'create']
    )->name('invoice.create');

    Route::post(
        '/invoice/store',
        [InvoiceController::class,'store']
    );

});