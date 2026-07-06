<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTestimonial extends Model
{
    protected $fillable = [
        'heading',
        'notes',
        'youtube_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Extract the 11-character YouTube video ID from any common URL form
     * (watch?v=, youtu.be/, embed/, shorts/), or null if it can't be parsed.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = trim((string) $this->youtube_url);
        if ($url === '') {
            return null;
        }

        // Already just an ID?
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url)) {
            return $url;
        }

        $patterns = [
            '/[?&]v=([A-Za-z0-9_-]{11})/',       // youtube.com/watch?v=ID
            '#youtu\.be/([A-Za-z0-9_-]{11})#',   // youtu.be/ID
            '#embed/([A-Za-z0-9_-]{11})#',       // youtube.com/embed/ID
            '#shorts/([A-Za-z0-9_-]{11})#',      // youtube.com/shorts/ID
            '#/v/([A-Za-z0-9_-]{11})#',          // youtube.com/v/ID
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $m)) {
                return $m[1];
            }
        }

        return null;
    }

    /** Privacy-friendly embed URL (nocookie) for iframes, or null. */
    public function getEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://www.youtube-nocookie.com/embed/{$this->youtube_id}" : null;
    }

    /** Watch URL on youtube.com, or the raw URL as a fallback. */
    public function getWatchUrlAttribute(): string
    {
        return $this->youtube_id ? "https://www.youtube.com/watch?v={$this->youtube_id}" : (string) $this->youtube_url;
    }

    /** High-quality thumbnail image URL, or null when the ID can't be parsed. */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }
}
