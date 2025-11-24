<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Global search route
Route::get('/search', [SearchController::class, 'search'])->name('search')->middleware('auth');

Route::fallback(function(){
    return view('404');
});

// Patient routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('patients', PatientController::class)->except(['destroy']);
    
    // Delete requires admin role
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])
        ->name('patients.destroy')
        ->middleware('admin');

    // Appointment routes
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);

    // Doctor routes
    // Doctor routes
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class);

    // Hospital Profile
    Route::get('/hospital/edit', [App\Http\Controllers\HospitalController::class, 'edit'])->name('hospital.edit');
    Route::put('/hospital/update', [App\Http\Controllers\HospitalController::class, 'update'])->name('hospital.update');

    // Departments
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);

    // Roles and Permissions
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // User Management
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Reports
    Route::get('/reports/patients', [App\Http\Controllers\ReportController::class, 'patientReports'])->name('reports.patients');
    Route::get('/reports/financial', [App\Http\Controllers\ReportController::class, 'financialReports'])->name('reports.financial');
    Route::get('/reports/inventory', [App\Http\Controllers\ReportController::class, 'inventoryReports'])->name('reports.inventory');
    Route::get('/reports/analytics', [App\Http\Controllers\ReportController::class, 'analytics'])->name('reports.analytics');

    // Inventory Management
    Route::resource('inventory/suppliers', App\Http\Controllers\SupplierController::class);
    Route::resource('inventory/categories', App\Http\Controllers\CategoryController::class);
    Route::resource('inventory/items', App\Http\Controllers\InventoryItemController::class);
    Route::get('inventory/stock', [App\Http\Controllers\StockController::class, 'index'])->name('stock.index');
    Route::get('inventory/stock/adjust/{item}', [App\Http\Controllers\StockController::class, 'adjust'])->name('stock.adjust');
    Route::post('inventory/stock/adjust/{item}', [App\Http\Controllers\StockController::class, 'storeAdjustment'])->name('stock.storeAdjustment');
    Route::get('inventory/stock/movements', [App\Http\Controllers\StockController::class, 'movements'])->name('stock.movements');
    Route::resource('inventory/purchase-orders', App\Http\Controllers\PurchaseOrderController::class);
    Route::get('inventory/purchase-orders/{purchaseOrder}/receive', [App\Http\Controllers\PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
    Route::post('inventory/purchase-orders/{purchaseOrder}/receive', [App\Http\Controllers\PurchaseOrderController::class, 'storeReceive'])->name('purchase-orders.storeReceive');

    // Billing Management
    Route::resource('billing/invoices', App\Http\Controllers\InvoiceController::class);
    Route::get('billing/invoices/{invoice}/print', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoices.print');
    Route::post('billing/payments', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('billing/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::delete('billing/payments/{payment}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::resource('billing/insurance-claims', App\Http\Controllers\InsuranceClaimController::class);
});
