<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('title') - Fondazione Marcegaglia Onlus Rwanda(FMO)</title>
    <meta description="@yield('description')">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">


    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"/>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}"/>
    <meta name="apple-mobile-web-app-title" content="Fondazione Marcegaglia Onlus Rwanda"/>
    <link rel="manifest" href="{{ asset('site.webmanifest') }}"/>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>

<body class="antialiased text-gray-900 font-sans">
<x-navigation-menu/>
<main class="flex-grow">
    {{ $slot }}
</main>
<x-footer-component/>
</body>
</html>
