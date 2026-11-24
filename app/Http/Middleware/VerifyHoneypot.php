<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Honeypot middleware — silently reject requests where the hidden field is filled.
 * Bots typically fill every visible and hidden field; humans leave the honeypot blank.
 */
class VerifyHoneypot
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the honeypot field has any value, it was filled by a bot
        if ($request->filled('_hp_field')) {
            // Silently return success to confuse the bot — no real processing
            return back()->with('success', 'Lamaran berhasil dikirim. Kami akan menghubungi Anda.');
        }

        return $next($request);
    }
}
