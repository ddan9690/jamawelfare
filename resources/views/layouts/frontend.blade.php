<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JamaWelfare | Secure Teacher Welfare Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
 
</head>
<body class="bg-stone-50 text-stone-900 font-sans antialiased" x-data="{ mobileMenu: false }">
    @include('frontend.partials.navigation')
    <main class="min-h-screen">@yield('content')</main>
    @include('frontend.partials.footer')
</body>
</html>