<?php

namespace App\Support;

class DeviceDetector
{
    public static function isMobile(?string $userAgent): bool
    {
        if (blank($userAgent)) {
            return false;
        }

        return (bool) preg_match('/Mobile|Android|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
    }

    public static function isBot(?string $userAgent): bool
    {
        if (blank($userAgent)) {
            return false;
        }

        return (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|preview/i', $userAgent);
    }
}
