<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionBundle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bundle_no',
        'buyer_id',
        'style_id',
        'line_id',
        'color',
        'size',
        'quantity',
        'completed_qty',
        'rejected_qty',
        'operator_name',
        'production_date',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'completed_qty' => 'integer',
        'rejected_qty' => 'integer',
        'production_date' => 'date:Y-m-d',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'balance_qty',
        'efficiency_percentage',
        'rejection_percentage',
        'status_label',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function sewingLine(): BelongsTo
    {
        return $this->belongsTo(SewingLine::class, 'line_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'bundle_id');
    }

    /**
     * Calculated Balance Quantity: Quantity - Completed - Rejected
     */
    public function getBalanceQtyAttribute(): int
    {
        return max(0, (int)$this->quantity - (int)$this->completed_qty - (int)$this->rejected_qty);
    }

    /**
     * Calculated Efficiency Percentage: (Completed / Quantity) * 100
     */
    public function getEfficiencyPercentageAttribute(): float
    {
        if ((int)$this->quantity <= 0) {
            return 0.0;
        }
        return round(((int)$this->completed_qty / (int)$this->quantity) * 100, 2);
    }

    /**
     * Calculated Rejection Percentage: (Rejected / Quantity) * 100
     */
    public function getRejectionPercentageAttribute(): float
    {
        if ((int)$this->quantity <= 0) {
            return 0.0;
        }
        return round(((int)$this->rejected_qty / (int)$this->quantity) * 100, 2);
    }

    /**
     * Current Production Status Badge
     */
    public function getStatusLabelAttribute(): string
    {
        $balance = $this->balance_qty;
        if ($balance === 0 && (int)$this->quantity > 0) {
            return (int)$this->rejected_qty > ((int)$this->quantity * 0.5) ? 'REJECTED' : 'PASSED';
        }
        if ((int)$this->completed_qty > 0 || (int)$this->rejected_qty > 0) {
            return 'IN PROGRESS';
        }
        return 'PENDING';
    }

    /**
     * Search Scope across bundle_no, buyer, style, operator, color
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function (Builder $q) use ($term) {
            $q->where('bundle_no', 'like', "%{$term}%")
              ->orWhere('operator_name', 'like', "%{$term}%")
              ->orWhere('color', 'like', "%{$term}%")
              ->orWhereHas('buyer', function (Builder $b) use ($term) {
                  $b->where('buyer_name', 'like', "%{$term}%");
              })
              ->orWhereHas('style', function (Builder $s) use ($term) {
                  $s->where('style_no', 'like', "%{$term}%");
              });
        });
    }

    /**
     * Filter Scope: buyer_id, style_id, line_id, date_from, date_to
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters['buyer_id'])) {
            $query->where('buyer_id', $filters['buyer_id']);
        }

        if (!empty($filters['style_id'])) {
            $query->where('style_id', $filters['style_id']);
        } elseif (!empty($filters['style_no'])) {
            $query->whereHas('style', function (Builder $s) use ($filters) {
                $s->where('style_no', 'like', "%" . trim($filters['style_no']) . "%");
            });
        }

        if (!empty($filters['line_id'])) {
            $query->where('line_id', $filters['line_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('production_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('production_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['color'])) {
            $query->where('color', 'like', "%" . trim($filters['color']) . "%");
        }

        if (!empty($filters['operator'])) {
            $query->where('operator_name', 'like', "%" . trim($filters['operator']) . "%");
        }

        return $query;
    }

    /**
     * Sort Scope: bundle_no, buyer, style, quantity, efficiency, production_date
     */
    public function scopeSort(Builder $query, ?string $sortBy = 'created_at', ?string $sortDir = 'desc'): Builder
    {
        $direction = strtolower($sortDir) === 'asc' ? 'asc' : 'desc';

        switch ($sortBy) {
            case 'bundle_no':
                return $query->orderBy('bundle_no', $direction);
            case 'quantity':
                return $query->orderBy('quantity', $direction);
            case 'completed_qty':
                return $query->orderBy('completed_qty', $direction);
            case 'rejected_qty':
                return $query->orderBy('rejected_qty', $direction);
            case 'production_date':
                return $query->orderBy('production_date', $direction);
            case 'efficiency':
                // (completed_qty / quantity) sorting expression
                return $query->orderByRaw("(CAST(completed_qty AS FLOAT) / CASE WHEN quantity = 0 THEN 1 ELSE quantity END) {$direction}");
            case 'buyer':
                return $query->join('buyers', 'production_bundles.buyer_id', '=', 'buyers.id')
                    ->orderBy('buyers.buyer_name', $direction)
                    ->select('production_bundles.*');
            case 'style':
                return $query->join('styles', 'production_bundles.style_id', '=', 'styles.id')
                    ->orderBy('styles.style_no', $direction)
                    ->select('production_bundles.*');
            default:
                return $query->orderBy('production_bundles.id', $direction);
        }
    }
}
