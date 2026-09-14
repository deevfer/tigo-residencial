<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Throwable;

class ZapierLeadWebhook
{
    public function send(Lead $lead, SiteSetting $settings): void
    {
        if ($lead->contact_preference !== 'call') {
            $lead->update(['zapier_status' => 'disabled']);

            return;
        }

        if (! $settings->zapier_enabled || blank($settings->zapier_webhook_url)) {
            $lead->update(['zapier_status' => 'disabled']);

            return;
        }

        $lead->update(['zapier_status' => 'pending']);

        try {
            $request = Http::timeout(10)
                ->acceptJson()
                ->asJson();

            if (filled($settings->zapier_secret)) {
                $request = $request->withHeaders([
                    'X-Zapier-Secret' => $settings->zapier_secret,
                ]);
            }

            $response = $request->post($settings->zapier_webhook_url, [
                'id' => $lead->id,
                'name' => $lead->name,
                'phone' => $lead->phone,
                'contact_preference' => $lead->contact_preference,
                'source' => $lead->source,
                'created_at' => $lead->created_at?->toIso8601String(),
                'ip_address' => $lead->ip_address,
                'user_agent' => $lead->user_agent,
            ]);

            $lead->update([
                'zapier_status' => $response->successful() ? 'sent' : 'failed',
                'zapier_sent_at' => $response->successful() ? now() : null,
                'zapier_response_code' => $response->status(),
                'zapier_response_body' => str($response->body())->limit(2000)->toString(),
                'zapier_error' => $response->successful() ? null : 'Zapier respondio con error.',
            ]);
        } catch (Throwable $exception) {
            $lead->update([
                'zapier_status' => 'failed',
                'zapier_error' => str($exception->getMessage())->limit(2000)->toString(),
            ]);
        }
    }
}
