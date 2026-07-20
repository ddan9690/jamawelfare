<nav class="bg-white border-b border-stone-200 sticky top-0 z-40 px-6 py-4 flex items-center justify-between">
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-2xl text-teal-900"><i class='bx bx-menu'></i></button>

    <!-- Welfare Switcher (Visible on all devices now) -->
    <div x-data="{ open: false }" class="relative block mx-auto">
        @if($activeWelfare)
            <button @click="open = !open" class="flex items-center gap-2 bg-stone-100 px-3 md:px-4 py-2 rounded-lg font-bold text-xs md:text-sm text-teal-900 border border-stone-200 hover:bg-stone-200 transition">
                <span class="truncate max-w-[120px] md:max-w-none">{{ $activeWelfare->name }}</span>
                <i class='bx bx-chevron-down'></i>
            </button>
            
            <div x-show="open" @click.away="open = false" class="absolute left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 mt-2 w-72 md:w-80 bg-white border rounded-xl shadow-xl p-2 z-50">
                <div class="px-3 py-2 text-[10px] font-bold text-stone-400 uppercase">Your Welfares</div>
                @foreach($userWelfares as $item)
                    <div class="flex items-center justify-between p-3 hover:bg-stone-50 rounded-lg">
                        <div>
                            <div class="font-bold text-sm text-teal-900">{{ $item->welfare->name }}</div>
                            <div class="text-[10px] text-stone-500 font-bold uppercase">{{ $item->role }}</div>
                        </div>
                        @if(session('active_welfare_id') != $item->welfare_id)
                            <form action="{{ route('welfare.switch', $item->welfare_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-teal-900 text-white text-[10px] px-3 py-1.5 rounded-lg hover:bg-amber-600 transition">Switch</button>
                            </form>
                        @else
                            <span class="text-[10px] text-teal-600 font-bold px-2">Active</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <a href="{{ route('frontend.explore') }}" class="text-xs md:text-sm font-bold text-amber-600 hover:text-amber-700 transition">
                Explore & Join Welfares
            </a>
        @endif
    </div>

    <!-- User Profile -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center gap-3 bg-stone-50 py-1.5 pl-2 pr-4 rounded-full border border-stone-200 hover:border-teal-900 transition">
            <div class="w-8 h-8 rounded-full bg-teal-900 text-white flex items-center justify-center text-xs font-black">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <span class="text-sm font-bold text-teal-900 hidden sm:inline">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
            <i class='bx bx-chevron-down text-stone-400'></i>
        </button>
        
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-xl p-2 z-50">
            <a href="#" class="block px-4 py-2 text-sm hover:bg-stone-50 text-stone-700">Profile</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Ready to leave?',
            text: "You will need to log in again to access your dashboard.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#064e3b',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
        })
    }
</script>