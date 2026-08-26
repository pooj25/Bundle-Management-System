<?php

use App\Http\Controllers\Api\BundleApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\BundleController;
use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// REST API Endpoints

// GET /api/dashboard
Route::get('/dashboard', [DashboardApiController::class, 'index']);

// Production Bundles Resource CRUD
Route::get('/bundles', [BundleApiController::class, 'index']);
Route::post('/bundles', [BundleApiController::class, 'store']);
Route::get('/bundles/{id}', [BundleApiController::class, 'show']);
Route::put('/bundles/{id}', [BundleApiController::class, 'update']);
Route::delete('/bundles/{id}', [BundleApiController::class, 'destroy']);
Route::get('/bundles-export', [BundleController::class, 'export']);

// Master Data APIs
Route::get('/buyers', function () {
    return response()->json([
        'success' => true,
        'data'    => Buyer::where('status', 'Active')->with('styles')->orderBy('buyer_name')->get(),
    ]);
});

Route::get('/styles', function (Request $request) {
    $query = Style::where('status', 'Active')->with('buyer');
    if ($request->buyer_id) {
        $query->where('buyer_id', $request->buyer_id);
    }
    return response()->json([
        'success' => true,
        'data'    => $query->orderBy('style_no')->get(),
    ]);
});

Route::get('/sewing-lines', function () {
    return response()->json([
        'success' => true,
        'data'    => SewingLine::where('status', 'Active')->orderBy('line_name')->get(),
    ]);
});
