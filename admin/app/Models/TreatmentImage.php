<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TreatmentImage extends Model
{
    protected $fillable = [
        'treatment_id',
        'image_path',
        'sort_order',
    ];

    protected static function booted(): void
    {
        // Always remove the file from disk when the row is deleted
        // (covers edits that remove images, single deletes, and cascades).
        static::deleting(function (TreatmentImage $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    /** Absolute URL to the image (public disk), or null. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
