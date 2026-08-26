<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBundleRequest;
use App\Http\Requests\UpdateBundleRequest;
use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use App\Services\BundleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BundleController extends Controller
{
    public function __construct(protected BundleService $bundleService) {}

    /**
     * Display listing page or return JSON for AJAX
     */
    public function index(Request $request)
    {
        $bundles = $this->bundleService->getPaginatedBundles($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $bundles->items(),
                'pagination' => [
                    'current_page'   => $bundles->currentPage(),
                    'last_page'      => $bundles->lastPage(),
                    'per_page'       => $bundles->perPage(),
                    'total'          => $bundles->total(),
                    'from'           => $bundles->firstItem(),
                    'to'             => $bundles->lastItem(),
                ],
            ]);
        }

        $buyers = Buyer::where('status', 'Active')->orderBy('buyer_name')->get();
        $lines = SewingLine::where('status', 'Active')->orderBy('line_name')->get();
        $styles = Style::where('status', 'Active')->orderBy('style_no')->get();

        return view('bundles.index', compact('bundles', 'buyers', 'lines', 'styles'));
    }

    /**
     * Display entry form page
     */
    public function create(): View
    {
        $buyers = Buyer::where('status', 'Active')->orderBy('buyer_name')->get();
        $lines = SewingLine::where('status', 'Active')->orderBy('line_name')->get();
        $nextBundleNo = 'BN-' . rand(1000, 9999);

        return view('bundles.create', compact('buyers', 'lines', 'nextBundleNo'));
    }

    /**
     * Store bundle via AJAX
     */
    public function store(StoreBundleRequest $request): JsonResponse
    {
        $bundle = $this->bundleService->createBundle(
            $request->validated(),
            $request->input('operator_name') ?: 'Admin',
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => "Production Bundle {$bundle->bundle_no} created successfully!",
            'data'    => $bundle,
        ], 201);
    }

    /**
     * Show single bundle
     */
    public function show(int $id): JsonResponse
    {
        $bundle = ProductionBundle::with(['buyer', 'style', 'sewingLine', 'activityLogs' => function ($q) {
            $q->latest('created_at')->limit(10);
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $bundle,
        ]);
    }

    /**
     * Edit bundle form/data
     */
    public function edit(int $id)
    {
        $bundle = ProductionBundle::with(['buyer', 'style', 'sewingLine'])->findOrFail($id);
        $buyers = Buyer::where('status', 'Active')->orderBy('buyer_name')->get();
        $lines = SewingLine::where('status', 'Active')->orderBy('line_name')->get();
        $styles = Style::where('buyer_id', $bundle->buyer_id)->where('status', 'Active')->orderBy('style_no')->get();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $bundle,
                'styles'  => $styles,
            ]);
        }

        return view('bundles.edit', compact('bundle', 'buyers', 'lines', 'styles'));
    }

    /**
     * Update bundle via AJAX
     */
    public function update(UpdateBundleRequest $request, int $id): JsonResponse
    {
        $bundle = ProductionBundle::findOrFail($id);
        $updatedBundle = $this->bundleService->updateBundle(
            $bundle,
            $request->validated(),
            $request->input('operator_name') ?: 'Admin',
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => "Production Bundle {$updatedBundle->bundle_no} updated successfully!",
            'data'    => $updatedBundle,
        ]);
    }

    /**
     * Soft delete bundle
     */
    public function destroy(int $id): JsonResponse
    {
        $bundle = ProductionBundle::findOrFail($id);
        $bundleNo = $bundle->bundle_no;

        $this->bundleService->deleteBundle($bundle, 'Admin', request()->ip());

        return response()->json([
            'success' => true,
            'message' => "Bundle {$bundleNo} deleted successfully (soft delete).",
            'deleted_id' => $id,
        ]);
    }

    /**
     * Restore a soft-deleted bundle
     */
    public function restore(int $id): JsonResponse
    {
        $bundle = $this->bundleService->restoreBundle($id, 'Admin', request()->ip());

        if (!$bundle) {
            return response()->json([
                'success' => false,
                'message' => 'Bundle not found or not deleted.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Bundle {$bundle->bundle_no} restored successfully!",
            'data'    => $bundle,
        ]);
    }

    /**
     * Print Bundle Slip
     */
    public function printSlip(int $id): View
    {
        $bundle = ProductionBundle::with(['buyer', 'style', 'sewingLine'])->findOrFail($id);
        return view('bundles.print_slip', compact('bundle'));
    }

    /**
     * Export to CSV / Excel
     */
    public function export(Request $request): StreamedResponse
    {
        $fileName = 'production_bundles_' . date('Y_m_d_His') . '.csv';

        $query = ProductionBundle::query()
            ->with(['buyer', 'style', 'sewingLine'])
            ->search($request->search)
            ->filter($request->all())
            ->sort($request->sort_by ?? 'created_at', $request->sort_dir ?? 'desc');

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        return response()->stream(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Bundle No',
                'Buyer',
                'Style',
                'Color',
                'Size',
                'Sewing Line',
                'Quantity',
                'Completed Qty',
                'Rejected Qty',
                'Balance Qty',
                'Efficiency (%)',
                'Rejection (%)',
                'Operator Name',
                'Production Date',
                'Status',
                'Remarks',
                'Created At',
            ]);

            // Stream chunks to conserve memory
            $query->chunk(500, function ($bundles) use ($handle) {
                foreach ($bundles as $bundle) {
                    fputcsv($handle, [
                        $bundle->bundle_no,
                        $bundle->buyer->buyer_name ?? 'N/A',
                        $bundle->style->style_no ?? 'N/A',
                        $bundle->color,
                        $bundle->size,
                        $bundle->sewingLine->line_name ?? 'N/A',
                        $bundle->quantity,
                        $bundle->completed_qty,
                        $bundle->rejected_qty,
                        $bundle->balance_qty,
                        $bundle->efficiency_percentage . '%',
                        $bundle->rejection_percentage . '%',
                        $bundle->operator_name ?? 'N/A',
                        $bundle->production_date ? Carbon::parse($bundle->production_date)->format('Y-m-d') : '',
                        $bundle->status_label,
                        $bundle->remarks ?? '',
                        $bundle->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}
