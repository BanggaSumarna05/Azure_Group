<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Verify a reCAPTCHA v2 token.
     * If secret key is not configured, skip verification (dev mode).
     */
    public static function verify(?string $token, string $action = 'submit'): bool
    {
        $secretKey = config('services.recaptcha.secret');

        // Skip verification if key not configured (local dev)
        if (empty($secretKey)) {
            return true;
        }

        if (empty($token)) {
            return false;
        }

        try {
            $response = Http::asForm()->post(self::VERIFY_URL, [
                'secret'   => $secretKey,
                'response' => $token,
            ]);

            $data = $response->json();

            if (! ($data['success'] ?? false)) {
                Log::warning('reCAPTCHA verification failed', ['errors' => $data['error-codes'] ?? []]);
                return false;
            }

            // v2 doesn't have score or action — just success/fail
            return true;

        } catch (\Throwable $e) {
            Log::error('reCAPTCHA request failed', ['error' => $e->getMessage()]);
            // Fail open on network error — don't block legitimate users
            return true;
        }
    }
}
