<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'color', 'excerpt', 'description',
        'price_from', 'duration_minutes', 'is_emergency', 'is_active',
        'is_featured', 'sort_order',
    ];

    protected $casts = [
        'is_emergency' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
