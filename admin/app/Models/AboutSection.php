<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutSection extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'experience_years' => 'integer',
    ];

    public const SAMPLE_SUBTITLE = 'Get To Know Us';
    public const SAMPLE_TITLE = "Complete Dental &\nAesthetic Care You Can Trust";
    public const SAMPLE_DESCRIPTION = 'From routine check-ups to smile makeovers and advanced aesthetic treatments, our experienced team combines modern technology with a gentle touch to give you the best care possible.';

    /**
     * Return the single about-section record, creating one (with sample
     * content) if it does not exist yet.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'subtitle' => self::SAMPLE_SUBTITLE,
                'title' => self::SAMPLE_TITLE,
                'description' => self::SAMPLE_DESCRIPTION,
            ]
        );
    }

    protected static function booted(): void
    {
        // Clean up the doctor photo when the record is deleted (rare, but tidy).
        static::deleting(function (AboutSection $about) {
            if ($about->doctor_photo_path) {
                Storage::disk('public')->delete($about->doctor_photo_path);
            }
        });
    }

    /** Absolute URL to the doctor photo (public disk), or null. */
    public function getDoctorPhotoUrlAttribute(): ?string
    {
        return $this->doctor_photo_path ? Storage::disk('public')->url($this->doctor_photo_path) : null;
    }

    /** Qualifications as a clean array (one per line), for list rendering. */
    public function getQualificationListAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->qualifications))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /** The configured stats as [value => ..., label => ...] pairs (only complete ones). */
    public function getStatsAttribute(): array
    {
        $stats = [];
        foreach ([1, 2, 3, 4] as $i) {
            $value = trim((string) $this->{"stat{$i}_value"});
            $label = trim((string) $this->{"stat{$i}_label"});
            if ($value !== '' && $label !== '') {
                $stats[] = ['value' => $value, 'label' => $label];
            }
        }

        return $stats;
    }
}
