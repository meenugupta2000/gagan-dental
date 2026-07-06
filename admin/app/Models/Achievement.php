<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'notes',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Clean up the image file when the achievement is deleted.
        static::deleting(function (Achievement $achievement) {
            if ($achievement->image_path) {
                Storage::disk('public')->delete($achievement->image_path);
            }
        });
    }

    /** Absolute URL to the achievement photo (public disk), or null. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
