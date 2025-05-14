<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Appliance AI">
        <link rel="mask-icon" href="{{ asset('images/blue-swirl.webp') }}" color="#106b87">
        <meta name="msapplication-TileColor" content="#106b87">
        <meta property="og:title" content="🤖 Appliance AI Assistant – Diagnose & Repair Instantly | Appliance AI" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:description" content="🛠️ Ask questions, run tests, and get real-time troubleshooting for washers, dryers, refrigerators and more with the Appliance AI assistant." />
        <meta name="theme-color" content="#106b87">
        <meta property="og:image" content="{{ asset('images/blue-swirl.webp') }}">
        <meta property="og:image:alt" content="🛠️ Ask questions, run tests, and get real-time troubleshooting for washers, dryers, refrigerators and more with the Appliance AI assistant." />
        <meta property="og:site_name" content="Appliance AI" />
        <link rel="canonical" href="{{ url()->current() }}" />

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="🤖 Appliance AI Assistant - Diagnose & Repair Instantly | Appliance AI">
        <meta property="twitter:description" content="🛠️ Ask questions, run tests, and get real-time troubleshooting for washers, dryers, refrigerators and more with the Appliance AI assistant.">
        <meta property="twitter:image" content="{{ asset('images/blue-swirl.webp') }}">
        <link as="image" href="{{ asset('images/blue-swirl.webp') }}">

        <title>🤖 Appliance AI Assistant - Diagnose & Repair Instantly | {{ config('app.name', 'Appliance AI') }}</title>

        <meta name="description" content="🛠️ Ask questions, run tests, and get real-time troubleshooting for washers, dryers, refrigerators and more with the Appliance AI assistant." />
        <link rel="icon" href="{{ asset('images/blue-swirl.webp') }}" type="image/webp">
        <link rel="shortcut icon" href="{{ asset('images/blue-swirl.webp') }}">

        @viteReactRefresh
        @vite(['resources/js/src/main.jsx', 'resources/css/app.css'])
    </head>
    <body>
        <div id="loading">Loading...</div>
        <div id="root"></div>
        <script>
            window.AccessToken = @json(session('token'));
            window.user = @json(auth()->user());
        </script>
    </body>
</html>
