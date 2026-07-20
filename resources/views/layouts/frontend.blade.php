<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>JamaWelfare | Digital Welfare Management System for Kenyan Teachers</title>
    <meta name="title" content="JamaWelfare | Digital Welfare & Contribution Management for Kenyan Teachers">
    <meta name="description" content="The ultimate welfare management software for primary, junior secondary, senior secondary, and tertiary educators in Kenya. Automate contributions, data recording, and transparent fund tracking.">
    <meta name="keywords" content="teacher welfare Kenya, primary teacher welfare, secondary school welfare management, tertiary educators welfare, welfare contribution software, teacher table banking, school staff welfare system, group ledger Kenya">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="JamaWelfare | Digital Welfare Management System for Kenyan Teachers">
    <meta property="og:description" content="The ultimate welfare management software for primary, junior secondary, senior secondary, and tertiary educators in Kenya. Automate contributions, data recording, and transparent fund tracking.">
    <meta property="og:image" content="{{ asset('images/og-cover.png') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/jamawelfare-favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}"> <!-- Fallback for older browsers -->

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-stone-50 text-stone-900 font-sans antialiased" x-data="{ mobileMenu: false }">
    @include('frontend.partials.navigation')
    <main class="min-h-screen">@yield('content')</main>
    @include('frontend.partials.footer')
</body>
</html>