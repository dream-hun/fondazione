<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
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
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">
    <!-- Main Content -->

    {{ $slot }}

</div>
</body>
</html>
