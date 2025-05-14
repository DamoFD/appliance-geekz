<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Appliance AI">
        <link rel="mask-icon" href="{{ asset('images/blue-swirl.webp') }}" color="#106b87">
        <meta name="msapplication-TileColor" content="#106b87">
        <meta property="og:title" content="@yield('title', 'Appliance AI')" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:description" content="@yield('description', 'Diagnose any appliance instantly')" />
        <meta name="theme-color" content="#106b87">
        <meta property="og:image" content="{{ asset('images/blue-swirl.webp') }}">
        <meta property="og:image:alt" content="@yield('description', 'Diagnose any appliance instantly')" />
        <meta property="og:site_name" content="Appliance AI" />
        <link rel="canonical" href="{{ url()->current() }}" />

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', 'Appliance AI')">
        <meta property="twitter:description" content="@yield('description', 'Appliance AI')">
        <meta property="twitter:image" content="{{ asset('images/blue-swirl.webp') }}">
        <link as="image" href="{{ asset('images/blue-swirl.webp') }}">

        <title>@yield('title', 'Appliance AI') | {{ config('app.name', 'Appliance AI') }}</title>

        <meta name="description" content="@yield('description', 'Diagnose any appliance instantly!')" />
        <link rel="icon" href="{{ asset('images/blue-swirl.webp') }}" type="image/webp">
        <link rel="shortcut icon" href="{{ asset('images/blue-swirl.webp') }}">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="bg-black w-full min-h-screen">
        <header x-data="{ open: false }" class="w-full z-50 absolute top-0 left-0 text-white font-inter">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-12 lg:px-8 py-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold tracking-tight text-white">
                    APPLIANCE<span class="text-primary">AI.</span>
                </a>

                <!-- Desktop nav -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#how-it-works" class="hover:text-primary transition">How it works</a>
                    <a href="#features" class="hover:text-primary transition">Features</a>
                    <a href="#faq" class="hover:text-primary transition">FAQ</a>
                    @if (auth()->check())
                        <form method="POST" action={{ route('logout') }}>
                            @csrf
                            <button type="submit" class="hover:text-primary transition">Logout</button>
                        </form>
                    @else
                        <a href={{ route('login') }} class="hover:text-primary transition">Login</a>
                        <a href={{ route('register') }} class="hover:text-primary transition">Register</a>
                    @endif
                    @if (auth()->check() && auth()->user()->isAdmin())
                        <a href={{ route('admin.index') }} class="hover:text-primary transition">Admin Dashboard</a>
                    @endif
                    <a href={{ route('dashboard') }} class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-opacity-90 transition">Try It</a>
                </nav>

                <!-- Hamburger -->
                <button aria-label="open-menu" @click="open = !open" class="md:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div x-show="open" x-transition class="md:hidden bg-black bg-opacity-50 backdrop-blur-md absolute top-full left-0 w-full py-6 space-y-4 px-6">
                <a href="#how-it-works" class="block text-lg hover:text-primary transition" @click="open = false">How it works</a>
                <a href="#features" class="block text-lg hover:text-primary transition" @click="open = false">Features</a>
                <a href="#faq" class="block text-lg hover:text-primary transition" @click="open = false">FAQ</a>
                @if (auth()->check())
                    <form action={{ route('logout') }} method="POST">
                        @csrf
                        <button type="submit" class="block text-lg hover:text-primary transition" @click="open = false">Logout</button>
                    </form>
                @else
                    <a href={{ route('login') }} class="block text-lg hover:text-primary transition" @click="open = false">Login</a>
                    <a href={{ route('register') }} class="block text-lg hover:text-primary transition" @click="open = false">Register</a>
                @endif
                @if (auth()->check() && auth()->user()->isAdmin())
                    <a href={{ route('admin.index') }} class="block text-lg hover:text-primary transition" @click="open = false">Admin Dashboard</a>
                @endif
                <a href={{ route('dashboard') }} class="block text-lg bg-primary px-4 py-2 rounded-lg text-center text-white hover:bg-opacity-90 transition" @click="open = false">Try It</a>
            </div>
        </header>
        {{ $slot }}
    </body>
</html>
