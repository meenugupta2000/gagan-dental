<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'qualification',
        'designation',
        'photo_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Clean up the photo file when the team member is deleted.
        static::deleting(function (TeamMember $member) {
            if ($member->photo_path) {
                Storage::disk('public')->delete($member->photo_path);
            }
        });
    }

    /** Absolute URL to the member photo (public disk), or null. */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null;
    }
}
