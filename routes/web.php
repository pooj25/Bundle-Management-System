<?php

use App\Http\Controllers\BundleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErpModulesController;
use App\Http\Controllers\MasterDataController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

// Production Bundle routes
Route::get('/bundles', [BundleController::class, 'index'])->name('bundles.index');
Route::get('/bundles/create', [BundleController::class, 'create'])->name('bundles.create');
Route::post('/bundles', [BundleController::class, 'store'])->name('bundles.store');
Route::get('/bundles/{id}', [BundleController::class, 'show'])->name('bundles.show');
Route::get('/bundles/{id}/edit', [BundleController::class, 'edit'])->name('bundles.edit');
Route::put('/bundles/{id}', [BundleController::class, 'update'])->name('bundles.update');
Route::delete('/bundles/{id}', [BundleController::class, 'destroy'])->name('bundles.destroy');
Route::post('/bundles/{id}/restore', [BundleController::class, 'restore'])->name('bundles.restore');
Route::get('/bundles/{id}/print', [BundleController::class, 'printSlip'])->name('bundles.print');
Route::get('/bundles-export', [BundleController::class, 'export'])->name('bundles.export');

// Master Data Management routes
Route::get('/master-data', [MasterDataController::class, 'index'])->name('master.index');
Route::get('/master-data/styles-by-buyer/{buyerId}', [MasterDataController::class, 'getStylesByBuyer'])->name('master.styles-by-buyer');
Route::post('/master-data/buyers', [MasterDataController::class, 'storeBuyer'])->name('master.buyers.store');
Route::post('/master-data/styles', [MasterDataController::class, 'storeStyle'])->name('master.styles.store');
Route::post('/master-data/lines', [MasterDataController::class, 'storeLine'])->name('master.lines.store');

// All ERP Factory Modules
Route::get('/sourcing', [ErpModulesController::class, 'sourcing'])->name('modules.sourcing');
Route::get('/cutting', [ErpModulesController::class, 'cutting'])->name('modules.cutting');
Route::get('/qc', [ErpModulesController::class, 'qc'])->name('modules.qc');
Route::get('/shipping', [ErpModulesController::class, 'shipping'])->name('modules.shipping');
Route::get('/settings', [ErpModulesController::class, 'settings'])->name('modules.settings');
Route::get('/support', [ErpModulesController::class, 'support'])->name('modules.support');
