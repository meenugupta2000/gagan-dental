<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Offer extends Model
{
    protected $fillable = [
        'image_path',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Clean up the image file when the offer is deleted.
        static::deleting(function (Offer $offer) {
            if ($offer->image_path) {
                Storage::disk('public')->delete($offer->image_path);
            }
        });
    }

    /** Absolute URL to the offer image (public disk), or null. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
