<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBundleRequest;
use App\Http\Requests\UpdateBundleRequest;
use App\Models\ProductionBundle;
use App\Services\BundleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BundleApiController extends Controller
{
    public function __construct(protected BundleService $bundleService) {}

    /**
     * GET /api/bundles
     * List bundles with pagination, filters, search, and sorting
     */
    public function index(Request $request): JsonResponse
    {
        $bundles = $this->bundleService->getPaginatedBundles($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Bundles retrieved successfully.',
            'data'       => $bundles->items(),
            'pagination' => [
                'current_page' => $bundles->currentPage(),
                'last_page'    => $bundles->lastPage(),
                'per_page'     => $bundles->perPage(),
                'total'        => $bundles->total(),
                'from'         => $bundles->firstItem(),
                'to'           => $bundles->lastItem(),
            ],
        ]);
    }

    /**
     * POST /api/bundles
     * Create a new bundle
     */
    public function store(StoreBundleRequest $request): JsonResponse
    {
        $bundle = $this->bundleService->createBundle(
            $request->validated(),
            $request->input('operator_name') ?: 'API Client',
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => 'Production bundle created successfully.',
            'data'    => $bundle,
        ], 201);
    }

    /**
     * GET /api/bundles/{id}
     * Get single bundle details
     */
    public function show(int $id): JsonResponse
    {
        $bundle = ProductionBundle::with(['buyer', 'style', 'sewingLine', 'activityLogs'])->find($id);

        if (!$bundle) {
            return response()->json([
                'success' => false,
                'message' => 'Bundle not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bundle details retrieved successfully.',
            'data'    => $bundle,
        ]);
    }

    /**
     * PUT /api/bundles/{id}
     * Update an existing bundle
     */
    public function update(UpdateBundleRequest $request, int $id): JsonResponse
    {
        $bundle = ProductionBundle::find($id);

        if (!$bundle) {
            return response()->json([
                'success' => false,
                'message' => 'Bundle not found.',
            ], 404);
        }

        $updated = $this->bundleService->updateBundle(
            $bundle,
            $request->validated(),
            $request->input('operator_name') ?: 'API Client',
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => 'Production bundle updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /api/bundles/{id}
     * Soft delete a bundle
     */
    public function destroy(int $id): JsonResponse
    {
        $bundle = ProductionBundle::find($id);

        if (!$bundle) {
            return response()->json([
                'success' => false,
                'message' => 'Bundle not found.',
            ], 404);
        }

        $this->bundleService->deleteBundle($bundle, 'API Client', request()->ip());

        return response()->json([
            'success' => true,
            'message' => 'Production bundle soft-deleted successfully.',
        ]);
    }
}
