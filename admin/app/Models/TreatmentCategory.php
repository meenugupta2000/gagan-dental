<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class TreatmentCategory extends Model
{
    /** Top-nav groups. Keys are stored in the `group` column; values are labels. */
    public const GROUPS = [
        'dental' => 'Dental',
        'skin' => 'Skin',
    ];

    public const DEFAULT_GROUP = 'dental';

    protected $fillable = [
        'name',
        'slug',
        'group',
        'description',
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
        // Clean up the image file when the category is deleted.
        static::deleting(function (TreatmentCategory $category) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
        });
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    /** Absolute URL to the category image (public disk), or null. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /** Human label for the nav group (e.g. "Dental", "Skin"). */
    public function getGroupLabelAttribute(): string
    {
        return self::GROUPS[$this->group] ?? ucfirst((string) $this->group);
    }
}
