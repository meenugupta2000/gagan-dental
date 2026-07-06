<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration',
        'treatment_category_id',
        'badge',
        'actual_price',
        'deal_price',
        'description',
        'sort_order',
        'is_active',
        'show_on_home',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_home' => 'boolean',
        'sort_order' => 'integer',
        'actual_price' => 'decimal:2',
        'deal_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // Delete gallery image rows (each row's own deleting event removes its
        // file) before the treatment is removed — works for controller deletes,
        // bulk deletes and DB cascades alike.
        static::deleting(function (Treatment $treatment) {
            $treatment->images()->get()->each->delete();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TreatmentCategory::class, 'treatment_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(TreatmentImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /** First gallery image URL (used as the listing thumbnail), or null. */
    public function getPrimaryImageUrlAttribute(): ?string
    {
        return optional($this->images->first())->image_url;
    }

    public function getFormattedActualPriceAttribute(): ?string
    {
        return $this->actual_price !== null ? number_format((float) $this->actual_price, 0) : null;
    }

    public function getFormattedDealPriceAttribute(): ?string
    {
        return $this->deal_price !== null ? number_format((float) $this->deal_price, 0) : null;
    }
}
