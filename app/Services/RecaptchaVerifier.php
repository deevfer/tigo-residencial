<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Throwable;

class RecaptchaVerifier
{
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

            return $response->successful() && $response->json('success') === true;
        } catch (Throwable) {
            return false;
        }
    }
}
