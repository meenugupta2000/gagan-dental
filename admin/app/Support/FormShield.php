<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Lightweight, dependency-free spam protection for public forms:
 *
 *  1. Honeypot — a hidden field real users never see. Bots that auto-fill every
 *     field will populate it, which flags the submission.
 *  2. Timing   — an encrypted render timestamp. Submissions that arrive faster
 *     than a human could realistically fill the form are rejected.
 *
 * Render the fields with the <x-form-shield /> Blade component and validate a
 * submission with FormShield::passes($request).
 */
class FormShield
{
    /** Honeypot field name (looks tempting to bots, ignored by humans). */
    public const HONEYPOT = 'website';

    /** Encrypted render-time field name. */
    public const TIMESTAMP = 'form_ts';

    /** An encrypted "form was rendered now" token for the timing check. */
    public static function token(): string
    {
        return Crypt::encryptString((string) time());
    }

    /**
     * True when the submission looks human:
     *   - the honeypot field is empty, and
     *   - at least $minSeconds elapsed since the form was rendered
     *     (a missing or tampered timestamp also fails).
     */
    public static function passes(Request $request, int $minSeconds = 3): bool
    {
        // Honeypot must be empty.
        if (filled($request->input(self::HONEYPOT))) {
            return false;
        }

        // Timing: decrypt the render time; forged/missing tokens fail.
        try {
            $renderedAt = (int) Crypt::decryptString((string) $request->input(self::TIMESTAMP));
        } catch (\Throwable $e) {
            return false;
        }

        return (time() - $renderedAt) >= $minSeconds;
    }
}
