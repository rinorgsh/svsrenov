<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        @php
            $seo = $page['props']['seo'] ?? [];
            $seoTitle = ($seo['title'] ?? null) ? $seo['title'] . ' - SVS RENOV' : 'SVS RENOV';
        @endphp

        <title inertia>{{ $seoTitle }}</title>
        @if(!empty($seo['description']))
        <meta inertia="description" name="description" content="{{ $seo['description'] }}">
        @endif
        @if(!empty($seo['noindex']))
        <meta inertia="robots" name="robots" content="noindex, nofollow">
        @else
        <link inertia="canonical" rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
        @foreach(($seo['alternates'] ?? []) as $lang => $href)
        <link inertia="alternate-{{ $lang }}" rel="alternate" hreflang="{{ $lang }}-BE" href="{{ $href }}">
        @endforeach
        @if(!empty($seo['alternates']['fr']))
        <link inertia="alternate-default" rel="alternate" hreflang="x-default" href="{{ $seo['alternates']['fr'] }}">
        @endif
        @endif

        <!-- Partage (Facebook, WhatsApp, LinkedIn…) -->
        <meta inertia="og:site_name" property="og:site_name" content="SVS RENOV">
        <meta inertia="og:type" property="og:type" content="{{ $seo['type'] ?? 'website' }}">
        <meta inertia="og:title" property="og:title" content="{{ $seoTitle }}">
        @if(!empty($seo['description']))
        <meta inertia="og:description" property="og:description" content="{{ $seo['description'] }}">
        @endif
        <meta inertia="og:url" property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
        <meta inertia="og:image" property="og:image" content="{{ $seo['image'] ?? asset('image/og-default.jpg') }}">
        <meta inertia="og:locale" property="og:locale" content="{{ $seo['locale'] ?? 'fr_BE' }}">
        <meta inertia="twitter:card" name="twitter:card" content="summary_large_image">

        <!-- Données structurées : fiche entreprise -->
        <script type="application/ld+json">{!! json_encode(\App\Support\Seo::organization(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
        @if(!empty($seo['jsonLd']))
        <script type="application/ld+json">{!! json_encode($seo['jsonLd'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
        @endif

        <!-- Favicons -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <meta name="theme-color" content="#B91C1C">
        <meta name="msapplication-TileColor" content="#B91C1C">
        <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|manrope:600,700,800&display=swap" rel="stylesheet" />

        <!-- Google Analytics 4 -->
        @if(config('services.google_analytics.measurement_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
                'send_page_view': false
            });
        </script>
        @endif

        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1599856248017532');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1599856248017532&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
