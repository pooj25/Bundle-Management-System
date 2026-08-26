<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BundleService;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    public function __construct(protected BundleService $bundleService) {}

    /**
     * GET /api/dashboard
     * Get real-time dashboard KPIs, daily volumes, and recent activity
     */
    public function index(): JsonResponse
    {
        $metrics = $this->bundleService->getDashboardMetrics();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard metrics retrieved successfully.',
            'data'    => $metrics,
        ]);
    }
}
