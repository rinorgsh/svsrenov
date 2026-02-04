<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicons -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('image/logo.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('image/logo.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('image/logo.png') }}">

        <!-- Android/Chrome -->
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/logo.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/logo.png') }}">

        <!-- Theme Color -->
        <meta name="theme-color" content="#C8102E">
        <meta name="msapplication-TileColor" content="#C8102E">
        <meta name="msapplication-TileImage" content="{{ asset('image/logo.png') }}">
        <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

        <!-- Web App Manifest -->
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
