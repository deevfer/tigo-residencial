<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Throwable;

class RecaptchaVerifier
{
    private const ACTION = 'lead_submit';

    private const MINIMUM_SCORE = 0.5;

    public function verify(?string $token, ?string $ipAddress, SiteSetting $settings): bool
    {
        if (! $settings->recaptchaEnabled()) {
            return true;
        }

        if (blank($token)) {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(8)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $settings->recaptcha_secret_key,
                    'response' => $token,
                    'remoteip' => $ipAddress,
                ]);

            return $response->successful()
                && $response->json('success') === true
                && $response->json('action') === self::ACTION
                && (float) $response->json('score', 0) >= self::MINIMUM_SCORE;
        } catch (Throwable) {
            return false;
        }
    }
}
