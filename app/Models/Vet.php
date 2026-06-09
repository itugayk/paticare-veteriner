<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vet extends Model
{
    protected $fillable = [
        'name', 'slug', 'title', 'specialty', 'bio', 'photo',
        'experience_years', 'focus_areas', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'focus_areas' => 'array',
        'is_active' => 'boolean',
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
