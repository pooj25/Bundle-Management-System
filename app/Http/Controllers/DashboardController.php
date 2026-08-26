<?php

namespace App\Http\Controllers;

use App\Services\BundleService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected BundleService $bundleService) {}

    public function index(): View
    {
        $metrics = $this->bundleService->getDashboardMetrics();
        return view('dashboard', compact('metrics'));
    }

    public function data(): JsonResponse
    {
        $metrics = $this->bundleService->getDashboardMetrics();
        return response()->json([
            'success' => true,
            'data'    => $metrics,
        ]);
    }
}
