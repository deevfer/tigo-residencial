<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots_index',
        'robots_follow',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'header_logo',
        'header_logo_alt',
        'favicon',
        'banner_image',
        'banner_alt',
        'banner_caption',
        'headline_prefix',
        'headline_highlight',
        'headline_suffix',
        'form_heading',
        'name_label',
        'name_placeholder',
        'phone_label',
        'phone_placeholder',
        'call_button_text',
        'microcopy',
        'whatsapp_button_text',
        'whatsapp_url',
        'success_message',
        'google_tag_id',
        'google_analytics_id',
        'facebook_pixel_id',
        'head_scripts',
        'body_start_scripts',
        'zapier_enabled',
        'zapier_webhook_url',
        'zapier_secret',
        'recaptcha_enabled',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'footer_line_1',
        'footer_line_2',
    ];

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'zapier_enabled' => 'boolean',
            'recaptcha_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->first() ?? static::query()->create();
    }

    public function assetUrl(?string $path, string $fallback): string
    {
        $path = $path ?: $fallback;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function robotsContent(): string
    {
        return ($this->robots_index ? 'index' : 'noindex') . ', ' . ($this->robots_follow ? 'follow' : 'nofollow');
    }

    public function recaptchaEnabled(): bool
    {
        return $this->recaptcha_enabled
            && filled($this->recaptcha_site_key)
            && filled($this->recaptcha_secret_key);
    }
}
