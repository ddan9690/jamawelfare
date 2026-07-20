<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | JamaWelfare</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Secure and transparent teacher welfare, contributions, and benevolence management system for Kenyan educators.')">
    <meta name="keywords"
        content="teacher welfare Kenya, welfare management system, contribution software, Kenyan educators welfare, JamaWelfare">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/jamawelfare-favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}"> <!-- Fallback for older browsers -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-stone-50 font-sans text-stone-900" x-data="{ sidebarOpen: false }">

    @include('dashboard.partials.sidebar')

    <div class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">

        @include('dashboard.partials.navigation')

        <main class="p-4 md:p-8">
            @yield('content')
        </main>

        @include('dashboard.partials.footer')

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
