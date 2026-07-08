<nav x-data="{ mobileMenu: false }" class="bg-white shadow-sm border-b border-stone-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="text-2xl font-black text-teal-900">
            Jama<span class="text-amber-600">Welfare</span>
        </a>

        <!-- Desktop Links -->
        <div class="hidden md:flex items-center space-x-8 font-medium">
            <a href="/" class="hover:text-amber-600">Home</a>
            <a href="/explore" class="hover:text-amber-600">Explore</a>
            <a href="/about" class="hover:text-amber-600">About</a>
            <a href="/frequetly-asked-questions" class="hover:text-amber-600">FAQ</a>
            <a href="/contact" class="hover:text-amber-600">Contact</a>
            
            @auth
                <a href="/dashboard" class="text-teal-900 font-bold hover:text-amber-600">Dashboard</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-stone-500 hover:text-red-600">Logout</button>
                </form>
            @else
                <a href="/login" class="hover:text-amber-600">Login</a>
                <a href="/register" class="bg-teal-900 text-white px-5 py-2 rounded-lg hover:bg-amber-600 transition">Get Started</a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-3xl text-teal-900">
            <i class='bx' :class="mobileMenu ? 'bx-x' : 'bx-menu'"></i>
        </button>
    </div>

    <!-- Mobile Dropdown -->
    <div x-show="mobileMenu" 
         x-transition 
         class="md:hidden bg-stone-100 border-t p-6 space-y-4 text-center font-medium">
        <a href="/" class="block hover:text-amber-600">Home</a>
        <a href="/explore" class="block hover:text-amber-600">Explore</a>
        <a href="/about" class="block hover:text-amber-600">About</a>
        <a href="/frequetly-asked-questions" class="block hover:text-amber-600">FAQ</a>
        <a href="/contact" class="block hover:text-amber-600">Contact</a>
        
        <hr class="border-stone-200">

        @auth
            <a href="/dashboard" class="block text-teal-900 font-bold">Dashboard</a>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="block w-full text-red-600">Logout</button>
            </form>
        @else
            <a href="/login" class="block hover:text-amber-600">Login</a>
            <a href="/register" class="block bg-teal-900 text-white py-2 rounded">Get Started</a>
        @endauth
    </div>
</nav>