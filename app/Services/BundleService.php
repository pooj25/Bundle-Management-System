<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ProductionBundle;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BundleService
{
    /**
     * Get paginated bundles with eager loading, search, filter, and sorting
     */
    public function getPaginatedBundles(array $params = []): LengthAwarePaginator
    {
        $perPage = in_array((int)($params['per_page'] ?? 20), [10, 20, 50, 100], true)
            ? (int)($params['per_page'] ?? 20)
            : 20;

        $query = ProductionBundle::query()
            ->with(['buyer', 'style', 'sewingLine'])
            ->search($params['search'] ?? null)
            ->filter([
                'buyer_id' => $params['buyer_id'] ?? null,
                'style_id' => $params['style_id'] ?? null,
                'style_no' => $params['style_no'] ?? null,
                'line_id'  => $params['line_id'] ?? null,
                'date_from' => $params['date_from'] ?? null,
                'date_to'   => $params['date_to'] ?? null,
                'color'    => $params['color'] ?? null,
                'operator' => $params['operator'] ?? null,
            ])
            ->sort($params['sort_by'] ?? 'created_at', $params['sort_dir'] ?? 'desc');

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new production bundle with audit log
     */
    public function createBundle(array $data, ?string $userName = 'System User', ?string $ipAddress = null): ProductionBundle
    {
        return DB::transaction(function () use ($data, $userName, $ipAddress) {
            $bundle = ProductionBundle::create($data);

            ActivityLog::create([
                'bundle_id'   => $bundle->id,
                'action'      => 'CREATED',
                'description' => "Bundle {$bundle->bundle_no} created with quantity {$bundle->quantity}",
                'user_name'   => $userName ?? 'Operator',
                'changes'     => $bundle->toArray(),
                'ip_address'  => $ipAddress,
            ]);

            return $bundle->load(['buyer', 'style', 'sewingLine']);
        });
    }

    /**
     * Update an existing production bundle with audit log
     */
    public function updateBundle(ProductionBundle $bundle, array $data, ?string $userName = 'System User', ?string $ipAddress = null): ProductionBundle
    {
        return DB::transaction(function () use ($bundle, $data, $userName, $ipAddress) {
            $original = $bundle->only(array_keys($data));
            $bundle->update($data);
            $changes = [
                'before' => $original,
                'after'  => $bundle->only(array_keys($data)),
            ];

            ActivityLog::create([
                'bundle_id'   => $bundle->id,
                'action'      => 'UPDATED',
                'description' => "Bundle {$bundle->bundle_no} updated",
                'user_name'   => $userName ?? 'Operator',
                'changes'     => $changes,
                'ip_address'  => $ipAddress,
            ]);

            return $bundle->fresh(['buyer', 'style', 'sewingLine']);
        });
    }

    /**
     * Soft delete a bundle with audit log
     */
    public function deleteBundle(ProductionBundle $bundle, ?string $userName = 'System User', ?string $ipAddress = null): bool
    {
        return DB::transaction(function () use ($bundle, $userName, $ipAddress) {
            $bundleNo = $bundle->bundle_no;
            $bundleId = $bundle->id;

            ActivityLog::create([
                'bundle_id'   => $bundleId,
                'action'      => 'DELETED',
                'description' => "Bundle {$bundleNo} was soft-deleted",
                'user_name'   => $userName ?? 'Operator',
                'ip_address'  => $ipAddress,
            ]);

            return (bool)$bundle->delete();
        });
    }

    /**
     * Restore a soft-deleted bundle
     */
    public function restoreBundle(int $id, ?string $userName = 'System User', ?string $ipAddress = null): ?ProductionBundle
    {
        return DB::transaction(function () use ($id, $userName, $ipAddress) {
            $bundle = ProductionBundle::withTrashed()->find($id);
            if (!$bundle) {
                return null;
            }

            $bundle->restore();

            ActivityLog::create([
                'bundle_id'   => $bundle->id,
                'action'      => 'RESTORED',
                'description' => "Bundle {$bundle->bundle_no} was restored",
                'user_name'   => $userName ?? 'Operator',
                'ip_address'  => $ipAddress,
            ]);

            return $bundle->load(['buyer', 'style', 'sewingLine']);
        });
    }

    /**
     * Get real-time Dashboard Metrics
     */
    public function getDashboardMetrics(): array
    {
        $today = Carbon::today()->toDateString();
        $last7Days = Carbon::today()->subDays(6)->toDateString();

        // Single optimized aggregation query for global stats
        $totals = DB::table('production_bundles')
            ->whereNull('deleted_at')
            ->selectRaw('
                COUNT(id) as total_bundles,
                COALESCE(SUM(quantity), 0) as total_quantity,
                COALESCE(SUM(completed_qty), 0) as total_completed,
                COALESCE(SUM(rejected_qty), 0) as total_rejected
            ')
            ->first();

        $totalBundles = (int)($totals->total_bundles ?? 0);
        $totalQty = (int)($totals->total_quantity ?? 0);
        $totalCompleted = (int)($totals->total_completed ?? 0);
        $totalRejected = (int)($totals->total_rejected ?? 0);

        $completionRate = $totalQty > 0 ? round(($totalCompleted / $totalQty) * 100, 1) : 0.0;
        $defectRate = $totalQty > 0 ? round(($totalRejected / $totalQty) * 100, 1) : 0.0;
        $avgEfficiency = $totalQty > 0 ? round(($totalCompleted / $totalQty) * 100, 1) : 0.0;

        // Today's statistics
        $todayStats = DB::table('production_bundles')
            ->whereNull('deleted_at')
            ->where('production_date', $today)
            ->selectRaw('
                COALESCE(SUM(completed_qty), 0) as today_produced,
                COALESCE(SUM(rejected_qty), 0) as today_rejected
            ')
            ->first();

        $todayProduced = (int)($todayStats->today_produced ?? 0);
        $todayRejected = (int)($todayStats->today_rejected ?? 0);

        // Daily Production Volume for the last 7 days
        $dailyVolumeRaw = DB::table('production_bundles')
            ->whereNull('deleted_at')
            ->where('production_date', '>=', $last7Days)
            ->groupBy('production_date')
            ->selectRaw('production_date, SUM(completed_qty) as produced, SUM(rejected_qty) as rejected, SUM(quantity) as planned')
            ->orderBy('production_date', 'asc')
            ->get()
            ->keyBy('production_date');

        $chartLabels = [];
        $chartProduced = [];
        $chartRejected = [];
        $chartPlanned = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->toDateString();
            $label = $i === 0 ? 'Today' : $date->format('D');

            $chartLabels[] = $label;
            $chartProduced[] = (int)($dailyVolumeRaw[$dateStr]->produced ?? 0);
            $chartRejected[] = (int)($dailyVolumeRaw[$dateStr]->rejected ?? 0);
            $chartPlanned[] = (int)($dailyVolumeRaw[$dateStr]->planned ?? 0);
        }

        // Recent bundle activity
        $recentBundles = ProductionBundle::query()
            ->with(['buyer', 'style', 'sewingLine'])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return [
            'total_bundles'    => $totalBundles,
            'total_quantity'   => $totalQty,
            'total_completed'  => $totalCompleted,
            'total_rejected'   => $totalRejected,
            'completion_rate'  => $completionRate,
            'defect_rate'      => $defectRate,
            'avg_efficiency'   => $avgEfficiency,
            'today_production' => $todayProduced,
            'today_rejection'  => $todayRejected,
            'chart' => [
                'labels'   => $chartLabels,
                'produced' => $chartProduced,
                'rejected' => $chartRejected,
                'planned'  => $chartPlanned,
            ],
            'recent_bundles'   => $recentBundles,
        ];
    }
}
