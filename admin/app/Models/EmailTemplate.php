<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'subject',
        'body',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Fetch an active template by its key, or null. */
    public static function active(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }

    /** Replace {{ placeholder }} tokens in a string with the given data. */
    public static function renderText(?string $text, array $data): string
    {
        return preg_replace_callback('/\{\{\s*([a-zA-Z_]+)\s*\}\}/', function ($m) use ($data) {
            return array_key_exists($m[1], $data) ? (string) $data[$m[1]] : $m[0];
        }, (string) $text);
    }
}
