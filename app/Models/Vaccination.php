<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    protected $fillable = [
        'pet_id', 'vet_id', 'name', 'administered_at', 'next_due_at',
        'batch_no', 'notes',
    ];

    protected $casts = [
        'administered_at' => 'date',
        'next_due_at' => 'date',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(Vet::class);
    }

    /** Reminder status used by the owner dashboard. */
    public function getReminderStatusAttribute(): string
    {
        if (! $this->next_due_at) {
            return 'none';
        }

        $now = Carbon::today();

        if ($this->next_due_at->isPast()) {
            return 'overdue';
        }

        if ($this->next_due_at->lte($now->copy()->addDays(30))) {
            return 'due_soon';
        }

        return 'ok';
    }
}
