@php
    $settings ??= \App\Models\SiteSetting::current();
    $metaTitle = $settings->meta_title ?: $settings->site_name;
    $metaDescription = $settings->meta_description ?: 'Adquiere un plan de Internet residencial Tigo desde 100 megas sin salir de casa.';
    $canonicalUrl = $settings->canonical_url ?: url()->current();
    $ogTitle = $settings->og_title ?: $metaTitle;
    $ogDescription = $settings->og_description ?: $metaDescription;
    $headerLogoUrl = $settings->assetUrl($settings->header_logo, 'images/tigo-logo-white.svg');
    $faviconUrl = $settings->favicon ? $settings->assetUrl($settings->favicon, '') : asset('favicon.ico');
    $bannerUrl = $settings->assetUrl($settings->banner_image, 'images/banner-tigo-residencial.jpeg');
    $ogImageUrl = $settings->assetUrl($settings->og_image ?: $settings->banner_image, 'images/banner-tigo-residencial.jpeg');
    $viewErrors = $errors ?? new \Illuminate\Support\ViewErrorBag();
    $recaptchaEnabled = $settings->recaptchaEnabled();
    $leadSubmitted = request()->boolean('sent');
    $leadDuplicate = request()->boolean('duplicate');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $metaTitle }}</title>
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <meta name="description" content="{{ $metaDescription }}">
    @if (filled($settings->meta_keywords))
        <meta name="keywords" content="{{ $settings->meta_keywords }}">
    @endif
    <meta name="robots" content="{{ $settings->robotsContent() }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $settings->site_name }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta name="twitter:card" content="{{ $settings->twitter_card ?: 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@' . 'context' => 'https://schema.org',
            '@' . 'type' => 'WebPage',
            'name' => $metaTitle,
            'description' => $metaDescription,
            'url' => $canonicalUrl,
            'image' => $ogImageUrl,
            'publisher' => [
                '@' . 'type' => 'Organization',
                'name' => $settings->site_name,
                'logo' => $headerLogoUrl,
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,700,800" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    @if ($recaptchaEnabled)
        <script src="https://www.google.com/recaptcha/api.js?render={{ urlencode($settings->recaptcha_site_key) }}"></script>
    @endif
    @if (filled($settings->google_tag_id))
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $settings->google_tag_id }}');
        </script>
    @endif
    @if (filled($settings->google_analytics_id))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings->google_analytics_id }}');
        </script>
    @endif
    @if (filled($settings->facebook_pixel_id))
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}
            (window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $settings->facebook_pixel_id }}');
            fbq('track', 'PageView');
        </script>
    @endif
    {!! $settings->head_scripts !!}
</head>
<body>
    @if (filled($settings->google_tag_id))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings->google_tag_id }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    @if (filled($settings->facebook_pixel_id))
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $settings->facebook_pixel_id }}&ev=PageView&noscript=1" alt=""></noscript>
    @endif
    {!! $settings->body_start_scripts !!}
    <div class="landing-page">
        <header class="brand-bar">
            <img class="brand-logo" src="{{ $headerLogoUrl }}" alt="{{ $settings->header_logo_alt }}">
        </header>

        <main class="landing-main">
            <div class="content-grid">
                <section class="promo" aria-label="Planes de Internet residencial desde 100 megas">
                    <figure class="hero-banner">
                        <img src="{{ $bannerUrl }}" alt="{{ $settings->banner_alt }}">
                        @if (filled($settings->banner_caption))
                            <figcaption>{{ $settings->banner_caption }}</figcaption>
                        @endif
                    </figure>

                    <div class="headline-block">
                        <h1 class="headline" id="landing-title">
                            {{ $settings->headline_prefix }}
                            <strong>{!! nl2br(e($settings->headline_highlight)) !!}</strong>
                            {{ $settings->headline_suffix }}
                        </h1>

                        <svg class="promo-icon" viewBox="0 0 254 210" aria-hidden="true">
                            <path class="wifi-wave wifi-wave-1" d="M1.52092 18.2855C-2.77756 22.0863 2.96605 28.5837 7.25838 24.787C18.9977 14.3985 34.601 8.67689 51.1943 8.67689C67.7877 8.67689 83.4524 14.3985 95.1897 24.787C99.4431 28.5488 105.228 22.0863 100.927 18.2855C87.6054 6.49535 69.9461 0 51.1943 0C32.4425 0 14.8448 6.49535 1.52092 18.2855Z" fill="currentColor"/>
                            <path class="wifi-wave wifi-wave-2" d="M51.1944 18.8622C36.6161 18.8622 22.7613 23.9353 12.178 33.1417C7.86111 36.8973 13.5207 43.4624 17.8663 39.6884C35.8986 23.9907 66.6153 24.042 84.584 39.6884C88.8579 43.4214 94.6138 36.9158 90.2723 33.1417C79.6931 23.9333 65.8158 18.8622 51.1944 18.8622Z" fill="currentColor"/>
                            <path class="wifi-wave wifi-wave-3" d="M24.0834 52.9233C25.6454 54.7251 28.386 54.9221 30.196 53.346C41.5459 43.4665 60.9352 43.4952 72.2522 53.346C76.5261 57.0791 82.2779 50.5734 77.9405 46.7994C55.0583 26.8823 16.1834 43.8051 24.0834 52.9233Z" fill="currentColor"/>
                            <path class="home-shape" d="M252.485 108.034L145.126 15.9644C143.506 14.5689 141.108 14.5689 139.489 15.9644L32.131 108.034C30.7535 109.214 30.2554 111.129 30.8847 112.83C31.514 114.536 33.1354 115.667 34.9495 115.667H62.8435V205.664C62.8435 208.059 64.7847 210.002 67.1769 210.002H217.439C219.831 210.002 221.773 208.059 221.773 205.664V115.667H249.667C251.481 115.667 253.102 114.536 253.731 112.83C254.361 111.131 253.861 109.214 252.485 108.034ZM217.439 106.988C215.047 106.988 213.106 108.931 213.106 111.326V201.323H71.5102V111.326C71.5102 108.931 69.569 106.988 67.1769 106.988H46.6684L142.307 24.9676L237.948 106.988H217.439Z" fill="currentColor"/>
                        </svg>
                    </div>
                </section>

                <section id="contacto" class="form-panel" aria-label="Formulario de contacto" aria-labelledby="landing-title">
                    <form class="lead-form" id="lead-form" action="{{ route('leads.store') }}" method="POST">
                        @csrf
                        <input class="honeypot" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
                        <input id="contact_preference" type="hidden" name="contact_preference" value="call">
                        @if ($recaptchaEnabled)
                            <input id="recaptcha_token" type="hidden" name="g-recaptcha-response">
                        @endif

                        @if ($leadSubmitted || $leadDuplicate)
                            <div class="status" role="status" tabindex="-1">
                                {{ $leadDuplicate
                                    ? ($settings->duplicate_message ?: 'Este numero ya se encuentra registrado. Uno de nuestros asesores lo estara contactando pronto.')
                                    : ($settings->success_message ?: 'Gracias. Un asesor te llamara en minutos.') }}
                            </div>
                        @endif

                        <div class="form-heading">
                            <span>{{ $settings->form_heading }}</span>
                        </div>

                        <div class="form-body">
                            <div class="field">
                                <label for="name">{{ $settings->name_label }}</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="{{ $settings->name_placeholder }}" autocomplete="name" required aria-required="true" maxlength="120">
                                @if ($viewErrors->has('name'))
                                    <span class="error">{{ $viewErrors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="field">
                                <label for="phone">{{ $settings->phone_label }}</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="{{ $settings->phone_placeholder }}" inputmode="numeric" autocomplete="tel" pattern="[2-7][0-9]{7}" maxlength="8" title="Ingresa un numero valido de Guatemala de 8 digitos" required aria-required="true" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8)">
                                @if ($viewErrors->has('phone'))
                                    <span class="error">{{ $viewErrors->first('phone') }}</span>
                                @endif
                            </div>

                            @if ($recaptchaEnabled && $viewErrors->has('g-recaptcha-response'))
                                <span class="error">{{ $viewErrors->first('g-recaptcha-response') }}</span>
                            @endif
                        </div>
                    </form>

                    <div class="cta-area">
                        <button class="call-button" type="submit" form="lead-form" onclick="document.getElementById('contact_preference').value = 'call'">
                            <span class="call-icon" aria-hidden="true">
                                <svg viewBox="0 0 92 94">
                                    <path d="M64.0081 93.9398H27.7214C23.5543 93.9398 20.1642 90.5348 20.1642 86.3495V7.59033C20.1642 3.40495 23.5543 -1.52588e-05 27.7214 -1.52588e-05H64.0081C68.1751 -1.52588e-05 71.5652 3.40495 71.5652 7.59033V86.3495C71.5652 90.5348 68.1751 93.9398 64.0081 93.9398ZM41.063 88.4134H50.6664C51.4547 88.4134 52.0954 87.7699 52.0954 86.9781C52.0954 86.1864 51.4547 85.5429 50.6664 85.5429H41.063C40.2747 85.5429 39.6341 86.1864 39.6341 86.9781C39.6341 87.7699 40.2747 88.4134 41.063 88.4134ZM47.0636 5.45405H44.6658C43.8775 5.45405 43.2368 6.09754 43.2368 6.88927C43.2368 7.68101 43.8775 8.32452 44.6658 8.32452H47.0636C47.8519 8.32452 48.4926 7.68101 48.4926 6.88927C48.4926 6.09754 47.8519 5.45405 47.0636 5.45405ZM68.7281 13.7489H23.0013V80.2371H68.7281V13.7481V13.7489Z" fill="currentColor"/>
                                    <path d="M2.80352 46.8909C2.80352 52.0616 4.36736 56.8757 7.04823 60.8901C7.47139 61.524 7.31018 62.3777 6.68465 62.8145C6.03809 63.2671 5.14096 63.104 4.70291 62.4492C1.64269 57.8775 0 52.5098 0 46.8909C0 41.2721 1.60502 36.0334 4.59602 31.4966C5.03145 30.8365 5.93295 30.67 6.58214 31.1243C7.20505 31.5594 7.36801 32.4078 6.95098 33.0408C4.32969 37.0248 2.80352 41.7839 2.80352 46.8909Z" fill="currentColor"/>
                                    <path d="M11.4918 46.8909C11.4918 50.2209 12.4766 53.3259 14.1701 55.9339C14.5809 56.5661 14.4171 57.4084 13.7986 57.8409C13.1424 58.2995 12.2383 58.119 11.8028 57.4485C9.77553 54.3295 8.68829 50.6935 8.68829 46.89C8.68829 43.0866 9.73611 39.5805 11.6942 36.499C12.1252 35.8206 13.0364 35.6357 13.6961 36.097C14.3067 36.5234 14.4819 37.3535 14.0833 37.9813C12.4433 40.5614 11.4927 43.6176 11.4927 46.8909H11.4918Z" fill="currentColor"/>
                                    <path d="M88.9259 46.8909C88.9259 52.0616 87.3621 56.8757 84.6812 60.8901C84.2581 61.524 84.4193 62.3777 85.0448 62.8145C85.6914 63.2671 86.5885 63.104 87.0266 62.4492C90.0868 57.8767 91.7295 52.5089 91.7295 46.8901C91.7295 41.2712 90.1244 36.0325 87.1334 31.4957C86.698 30.8357 85.7965 30.6691 85.1473 31.1234C84.5244 31.5585 84.3615 32.4069 84.7785 33.04C87.3998 37.0239 88.9259 41.783 88.9259 46.8901V46.8909Z" fill="currentColor"/>
                                    <path d="M80.2367 46.8909C80.2367 50.2209 79.252 53.3259 77.5585 55.9339C77.1476 56.5661 77.3114 57.4084 77.93 57.8409C78.5862 58.2995 79.4903 58.119 79.9257 57.4485C81.953 54.3295 83.0403 50.6935 83.0403 46.89C83.0403 43.0866 81.9924 39.5805 80.0344 36.499C79.6033 35.8206 78.6922 35.6357 78.0325 36.097C77.4218 36.5234 77.2466 37.3535 77.6452 37.9813C79.2853 40.5614 80.2359 43.6176 80.2359 46.8909H80.2367Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <span class="call-text">{{ $settings->call_button_text }}</span>
                        </button>

                        <p class="microcopy">{{ $settings->microcopy }}</p>

                        @if ($settings->whatsapp_enabled)
                        <button class="whatsapp-button" type="submit" form="lead-form" onclick="document.getElementById('contact_preference').value = 'whatsapp'">
                            <span class="whatsapp-icon" aria-hidden="true">
                                <svg viewBox="0 0 32 32">
                                    <path fill="none" stroke="#ffffff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" d="M16 3.5A12.1 12.1 0 0 0 5.8 22.2L4 28l6-1.7A12.1 12.1 0 1 0 16 3.5Z"/>
                                    <path fill="#ffffff" d="M22.5 18.7c-.3-.2-2-1-2.3-1.1s-.6-.2-.8.2c-.2.3-.9 1.1-1.1 1.3s-.4.2-.8.1a9.6 9.6 0 0 1-4.7-4.1c-.2-.4 0-.6.1-.8l.6-.7c.2-.2.2-.4.3-.6s0-.5 0-.6l-1-2.4c-.3-.6-.5-.5-.8-.5h-.7c-.2 0-.6.1-.9.4s-1.2 1.1-1.2 2.8 1.2 3.2 1.4 3.4 2.4 3.8 5.9 5.3c.8.4 1.5.6 2 .7.9.3 1.7.2 2.3.1.7-.1 2-.8 2.3-1.6s.3-1.5.2-1.6-.3-.2-.7-.4Z"/>
                                </svg>
                            </span>
                            <span class="whatsapp-text">{{ $settings->whatsapp_button_text }}</span>
                        </button>
                        @endif
                    </div>
                </section>
            </div>
        </main>

        <footer class="landing-footer">
            <p>{{ $settings->footer_line_1 }}</p>
            <p>{{ $settings->footer_line_2 }}</p>
        </footer>
    </div>
    @if ($recaptchaEnabled)
        <script>
            (() => {
                const form = document.getElementById('lead-form');
                if (!form) return;

                let recaptchaReady = false;

                form.addEventListener('submit', (event) => {
                    if (recaptchaReady) return;

                    event.preventDefault();
                    grecaptcha.ready(() => {
                        grecaptcha.execute(@js($settings->recaptcha_site_key), { action: 'lead_submit' })
                            .then((token) => {
                                document.getElementById('recaptcha_token').value = token;
                                recaptchaReady = true;
                                form.requestSubmit(event.submitter);
                            });
                    });
                });
            })();
        </script>
    @endif
</body>
</html>
