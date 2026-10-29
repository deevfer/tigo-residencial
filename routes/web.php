<?php

use App\Models\Lead;
use App\Models\PageView;
use App\Models\SiteSetting;
use App\Services\RecaptchaVerifier;
use App\Services\ZapierLeadWebhook;
use App\Support\DeviceDetector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if (! DeviceDetector::isBot($request->userAgent())) {
        PageView::create([
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);
    }

    return view('landing', [
        'settings' => SiteSetting::current(),
    ]);
});

Route::post('/leads', function (Request $request) {
    abort_if(filled($request->input('website')), 204);

    $settings = SiteSetting::current();
    $recaptchaEnabled = $settings->recaptchaEnabled();

    $request->merge([
        'phone' => preg_replace('/\D+/', '', (string) $request->input('phone')),
    ]);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'phone' => ['required', 'digits:8'],
        'contact_preference' => ['required', $settings->whatsapp_enabled ? 'in:call,whatsapp' : 'in:call'],
        'g-recaptcha-response' => [$recaptchaEnabled ? 'required' : 'nullable', 'string'],
    ], [
        'name.required' => 'Ingresa tu nombre y apellido.',
        'phone.required' => 'Ingresa tu numero de telefono.',
        'phone.digits' => 'El numero de telefono debe tener exactamente 8 digitos.',
        'g-recaptcha-response.required' => 'Confirma que no eres un robot.',
    ]);

    if ($recaptchaEnabled && ! app(RecaptchaVerifier::class)->verify($validated['g-recaptcha-response'] ?? null, $request->ip(), $settings)) {
        return back()
            ->withErrors(['g-recaptcha-response' => 'No pudimos validar reCAPTCHA. Intentalo nuevamente.'])
            ->withInput();
    }

    $lead = Cache::lock('lead-phone:'.$validated['phone'], 10)->block(5, function () use ($request, $validated) {
        if (Lead::where('phone', $validated['phone'])->exists()) {
            return null;
        }

        return Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'contact_preference' => $validated['contact_preference'],
            'source' => 'residencial',
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);
    });

    if (! $lead) {
        return redirect(url('/').'/?duplicate=1#contacto');
    }

    app(ZapierLeadWebhook::class)->send($lead, $settings);

    if ($settings->whatsapp_enabled && $validated['contact_preference'] === 'whatsapp' && filled($settings->whatsapp_url)) {
        return redirect()->away($settings->whatsapp_url);
    }

    return redirect(url('/').'/?sent=1#contacto');
})->name('leads.store');
