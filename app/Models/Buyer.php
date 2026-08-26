<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_name',
        'contact_person',
        'email',
        'status',
    ];

    public function styles(): HasMany
    {
        return $this->hasMany(Style::class);
    }

    public function productionBundles(): HasMany
    {
        return $this->hasMany(ProductionBundle::class);
    }
}
