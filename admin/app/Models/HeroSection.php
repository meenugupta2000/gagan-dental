<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSection extends Model
{
    protected $guarded = ['id'];

    /** Recommended background image size, surfaced in the admin UI. */
    public const RECOMMENDED_RESOLUTION = '1920 × 1080 px';

    /** Recommended portrait size for the phone-only hero image. */
    public const RECOMMENDED_MOBILE_RESOLUTION = '1080 × 1350 px';

    /** Recommended inner-page banner size (wide, short). */
    public const RECOMMENDED_BANNER_RESOLUTION = '1920 × 600 px';

    /** Theme default used when no inner-page banner is uploaded. */
    public const DEFAULT_INNER_BANNER = 'assets/img/hero/home-5/bg-hero.jpg';

    /** Sample/default content used until the admin customises it. */
    public const SAMPLE_PUNCHLINE = "Healthy Smiles,\nConfident You";
    public const SAMPLE_DESCRIPTION = 'Advanced dental care and aesthetic treatments under one roof — gentle, modern and personalised, so every visit leaves you smiling with confidence.';

    /**
     * Return the single hero-section record, creating a blank one (with sample
     * content) if it does not exist yet.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'punchline' => self::SAMPLE_PUNCHLINE,
                'description' => self::SAMPLE_DESCRIPTION,
            ]
        );
    }

    /**
     * Absolute URL to the background image, or null when none is set.
     * Uses the public disk URL (APP_URL/storage → admin/public/storage) so it
     * resolves correctly from the public site as well as the admin.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /**
     * Absolute URL to the phone-only portrait hero image, or null when none set.
     */
    public function getMobileImageUrlAttribute(): ?string
    {
        return $this->mobile_image_path ? Storage::disk('public')->url($this->mobile_image_path) : null;
    }

    /**
     * Absolute URL to the uploaded inner-page banner, or null when none is set.
     */
    public function getInnerBannerUrlAttribute(): ?string
    {
        return $this->inner_banner_path ? Storage::disk('public')->url($this->inner_banner_path) : null;
    }

    /**
     * Inner-page banner URL with a graceful fallback to the bundled theme image.
     */
    public function getInnerBannerOrDefaultAttribute(): string
    {
        return $this->inner_banner_url ?? asset(self::DEFAULT_INNER_BANNER);
    }
}
