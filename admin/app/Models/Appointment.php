<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /** Workflow states an appointment request moves through. */
    public const STATUSES = ['new', 'contacted', 'confirmed', 'completed', 'cancelled'];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'treatment_id',
        'treatment_name',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    /**
     * Display label for the requested treatment: the free-text value the patient
     * typed, falling back to a linked treatment's name for older records.
     */
    public function getTreatmentLabelAttribute(): ?string
    {
        return $this->treatment_name ?: optional($this->treatment)->name;
    }
}
