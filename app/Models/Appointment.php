<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'pet_id', 'service_id', 'vet_id', 'date', 'time_slot',
        'status', 'owner_name', 'owner_phone', 'owner_email',
        'pet_name', 'pet_species', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public const STATUSES = [
        'pending' => 'Onay Bekliyor',
        'confirmed' => 'Onaylandı',
        'completed' => 'Tamamlandı',
        'cancelled' => 'İptal Edildi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(Vet::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
