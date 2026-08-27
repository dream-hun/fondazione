<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('title') - Fondazione Marcegaglia ETS Rwanda(FM ETS)</title>
    <meta name="description" content="@yield('description', 'Fondazione Marcegaglia ETS Rwanda empowers women and communities through education, healthcare, and sustainable development.')">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', request()->url())">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og:title', 'Fondazione Marcegaglia ETS Rwanda')">
    <meta property="og:description" content="@yield('og:description', 'Empowering women and communities in Rwanda through education, healthcare, and sustainable development.')">
    <meta property="og:image" content="@yield('og:image', asset('images/herosection.avif'))">
    <meta property="og:url" content="@yield('og:url', request()->url())">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="Fondazione Marcegaglia ETS Rwanda">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter:title', 'Fondazione Marcegaglia ETS Rwanda')">
    <meta name="twitter:description" content="@yield('twitter:description', 'Empowering women and communities in Rwanda through education, healthcare, and sustainable development.')">
    <meta name="twitter:image" content="@yield('twitter:image', asset('images/herosection.avif'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"/>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}"/>
    <meta name="apple-mobile-web-app-title" content="Fondazione Marcegaglia ETS Rwanda"/>
    <link rel="manifest" href="{{ asset('site.webmanifest') }}"/>

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WQLMW4F2');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body class="antialiased text-gray-900 font-sans">
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WQLMW4F2"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <x-navigation-menu/>
<main class="flex-grow">
    {{ $slot }}
</main>
<x-footer-component/>
</body>
</html>
