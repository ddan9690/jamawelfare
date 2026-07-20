<nav x-data="{ mobileMenu: false }" class="bg-white shadow-md border-b border-stone-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">
        <!-- Logo (Significantly increased height and adjusted padding) -->
        <a href="/" class="flex items-center shrink-0 py-1">
            <img src="{{ asset('images/jamawelfare-logo.svg') }}" alt="JamaWelfare Logo" class="h-12 md:h-14 w-auto block" width="220" height="56">
        </a>

        <!-- Desktop Links -->
        <div class="hidden md:flex items-center space-x-8 font-medium text-stone-700">
            <a href="/" class="hover:text-amber-600 transition {{ request()->is('/') ? 'text-teal-900 font-semibold' : '' }}">Home</a>
            <a href="/explore" class="hover:text-amber-600 transition {{ request()->is('explore*') ? 'text-teal-900 font-semibold' : '' }}">Explore</a>
            <a href="/about" class="hover:text-amber-600 transition {{ request()->is('about') ? 'text-teal-900 font-semibold' : '' }}">About</a>
            <a href="/frequetly-asked-questions" class="hover:text-amber-600 transition {{ request()->is('frequetly-asked-questions') ? 'text-teal-900 font-semibold' : '' }}">FAQ</a>
            <a href="/contact" class="hover:text-amber-600 transition {{ request()->is('contact') ? 'text-teal-900 font-semibold' : '' }}">Contact</a>
            
            @auth
                <a href="/dashboard" class="text-teal-900 font-bold hover:text-amber-600 transition">Dashboard</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-stone-500 hover:text-red-600 transition text-sm">Logout</button>
                </form>
            @else
                <a href="/login" class="hover:text-amber-600 transition">Login</a>
                <a href="/register" class="bg-teal-900 text-white px-5 py-2.5 rounded-xl hover:bg-teal-800 transition shadow-sm font-semibold text-sm">Get Started</a>
            @endauth
        </div>

        <!-- Mobile Hamburger (Centered vertically with larger logo) -->
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-4xl text-teal-900 focus:outline-none p-1 flex items-center" aria-label="Toggle Menu">
            <i class='bx' :class="mobileMenu ? 'bx-x' : 'bx-menu'"></i>
        </button>
    </div>

    <!-- Mobile Dropdown -->
    <div x-show="mobileMenu" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-white border-t border-stone-100 shadow-inner p-6 space-y-4 text-center font-medium">
        
        <a href="/" class="block py-2.5 hover:text-amber-600 transition {{ request()->is('/') ? 'text-teal-900 bg-stone-50 rounded-lg' : '' }}">Home</a>
        <a href="/explore" class="block py-2.5 hover:text-amber-600 transition {{ request()->is('explore*') ? 'text-teal-900 bg-stone-50 rounded-lg' : '' }}">Explore</a>
        <a href="/about" class="block py-2.5 hover:text-amber-600 transition {{ request()->is('about') ? 'text-teal-900 bg-stone-50 rounded-lg' : '' }}">About</a>
        <a href="/frequetly-asked-questions" class="block py-2.5 hover:text-amber-600 transition {{ request()->is('frequetly-asked-questions') ? 'text-teal-900 bg-stone-50 rounded-lg' : '' }}">FAQ</a>
        <a href="/contact" class="block py-2.5 hover:text-amber-600 transition {{ request()->is('contact') ? 'text-teal-900 bg-stone-50 rounded-lg' : '' }}">Contact</a>
        
        <div class="pt-5 pb-3 border-t border-stone-100 space-y-4">
            @auth
                <a href="/dashboard" class="block py-3 text-teal-900 font-bold text-lg bg-teal-50 rounded-xl">Dashboard</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="block w-full py-2 text-red-600 font-semibold">Logout</button>
                </form>
            @else
                <a href="/login" class="block py-3 text-teal-900 font-semibold text-lg">Login</a>
                <a href="/register" class="block bg-teal-900 text-white py-3.5 rounded-xl font-semibold shadow-sm text-lg">Get Started</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Alpine 'cloak' style -->
<style>
    [x-cloak] { display: none !important; }
</style>