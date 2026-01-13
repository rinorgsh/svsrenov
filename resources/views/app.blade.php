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

        <!-- Google Tag Manager -->
        @if(config('services.google_tag_manager.container_id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('services.google_tag_manager.container_id') }}');</script>
        @endif
        <!-- End Google Tag Manager -->

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Google Tag Manager (noscript) -->
        @if(config('services.google_tag_manager.container_id'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google_tag_manager.container_id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif
        <!-- End Google Tag Manager (noscript) -->

        @inertia
    </body>
</html>
