<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image_path',
        'content',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /** Absolute URL to the featured image (public disk), or null. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /** Plain-text snippet of the content for listing cards. */
    public function getExcerptAttribute(): string
    {
        // Replace block-closing tags with a space so words don't run together.
        $text = strip_tags(str_ireplace(['</p>', '</h1>', '</h2>', '</h3>', '</h4>', '</li>', '<br>', '<br/>', '<br />'], ' ', (string) $this->content));
        $text = trim(preg_replace('/\s+/', ' ', $text));

        return \Illuminate\Support\Str::limit($text, 130);
    }
}
