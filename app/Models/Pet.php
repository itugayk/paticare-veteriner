<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $fillable = [
        'user_id', 'name', 'species', 'breed', 'gender', 'birth_date',
        'weight_kg', 'color', 'microchip_no', 'is_neutered', 'photo', 'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_neutered' => 'boolean',
        'weight_kg' => 'decimal:2',
    ];

    public const SPECIES = [
        'kedi' => 'Kedi',
        'kopek' => 'Köpek',
        'kus' => 'Kuş',
        'kemirgen' => 'Kemirgen',
        'surungen' => 'Sürüngen',
        'diger' => 'Diğer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class)->orderByDesc('administered_at');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class)->orderByDesc('date');
    }

    public function getSpeciesLabelAttribute(): string
    {
        return self::SPECIES[$this->species] ?? ucfirst((string) $this->species);
    }

    public function getEmojiAttribute(): string
    {
        return match ($this->species) {
            'kedi' => '🐱',
            'kopek' => '🐶',
            'kus' => '🐦',
            'kemirgen' => '🐹',
            'surungen' => '🦎',
            default => '🐾',
        };
    }

    public function getAgeAttribute(): ?string
    {
        if (! $this->birth_date) {
            return null;
        }

        $months = $this->birth_date->diffInMonths(Carbon::now());

        if ($months < 12) {
            return $months . ' aylık';
        }

        $years = intdiv($months, 12);
        $rem = $months % 12;

        return $rem ? "{$years} yıl {$rem} ay" : "{$years} yaşında";
    }
}
