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
use App\Http\Controllers\HistoryTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\FrancoController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\JenisItemPOController;
use App\Http\Controllers\ItemPOController;
use App\Http\Controllers\CustomerPOController;
use App\Http\Controllers\UserController;

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

    Route::resource('users', UserController::class);

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

    Route::post(
        '/invoice/{id}/update-jenis',
        [InvoiceController::class, 'updateJenisInvoice']
    )->name('invoice.updateJenis');

    // Route::get(
    //     '/invoice/{id}',
    //     [InvoiceController::class, 'show']
    // )->name('invoice.show');
    
    Route::post(
        '/invoice/{id}/payment',
        [InvoiceController::class, 'storePayment']
    )->name('invoice.payment.store');

    Route::get(
        '/historytransaction',
        [HistoryTransactionController::class,'index']
    )->name('history.index');

    Route::get('/invoice/export/excel', [InvoiceController::class, 'exportExcel'])
        ->name('invoice.export.excel');


    //Purchase Order
    Route::resource('top', TopController::class);
    Route::resource('franco', FrancoController::class);
    Route::resource('po', PurchaseOrderController::class);
    Route::get('/po/dashboard', [PurchaseOrderController::class, 'dashboard'])->name('po.dashboard');
    Route::get('/po/list', [PurchaseOrderController::class, 'index'])->name('po.list');
    Route::resource('jenis-item', JenisItemPOController::class)
        ->parameters(['jenis-item' => 'jenis_item']);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customerpos', CustomerPOController::class);
    Route::resource('item-po', ItemPOController::class);
    Route::get('/po/{id}/print', [PurchaseOrderController::class, 'print'])->name('po.print');
    Route::get('/dashboardpo', [DashboardController::class, 'dashboardPO'])->name('po.dashboard');

    
});