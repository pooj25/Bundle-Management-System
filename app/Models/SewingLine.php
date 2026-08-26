<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SewingLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_name',
        'floor',
        'capacity',
        'status',
    ];

    public function productionBundles(): HasMany
    {
        return $this->hasMany(ProductionBundle::class);
    }
}
