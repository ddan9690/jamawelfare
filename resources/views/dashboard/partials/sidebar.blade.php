<div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 w-64 bg-teal-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 z-50 overflow-y-auto shadow-xl">

    <div class="p-6 flex items-center justify-between border-b border-teal-800">
        <div class="text-xl font-black text-amber-500">
            Jama<span class="text-white">Welfare</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-white text-2xl">
            <i class='bx bx-x'></i>
        </button>
    </div>

    <div class="px-6 py-6 space-y-8">

        <div>
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 py-2 text-sm transition {{ request()->routeIs('dashboard') ? 'text-amber-400 font-bold' : 'hover:text-amber-400' }}">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
            </nav>
        </div>

        @if (auth()->user()->is_super_admin)
            <div>
                <p class="text-[10px] uppercase font-bold text-teal-400 mb-3 tracking-wider">System Admin</p>
                <nav class="space-y-1">
                    <a href="{{ route('welfares.index') }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition {{ request()->routeIs('welfares.*') ? 'text-amber-500 font-bold' : '' }}">
                        <i class='bx bx-building'></i> Welfares
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition">
                        <i class='bx bx-user-group'></i> User Management
                    </a>
                </nav>
            </div>
        @endif

        @if (isset($activeWelfare) && $activeWelfare && ($activeMemberRole === 'admin' || auth()->user()->is_super_admin))
            <div>
                <p class="text-[10px] uppercase font-bold text-teal-400 mb-3 tracking-wider">Welfare Management</p>
                <nav class="space-y-1">
                    <a href="{{ route('welfares.show', ['id' => $activeWelfare->id, 'slug' => $activeWelfare->slug]) }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition {{ request()->routeIs('welfares.show') ? 'text-amber-500 font-bold' : '' }}">
                        <i class='bx bx-grid-alt'></i> Welfare Dashboard
                    </a>
                    <a href="{{ route('benevolence-categories.index') }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition">
                        <i class='bx bx-list-ol'></i> Benevolence Categories
                    </a>
                    <a href="{{ route('benevolence-cases.index') }}"
                        class="flex items-center gap-3 py-2 text-sm transition {{ request()->routeIs('benevolence-cases.*') ? 'text-amber-400 font-bold' : 'hover:text-amber-400' }}">
                        <i class='bx bx-error-circle'></i> Benevolence Cases
                    </a>
                </nav>
            </div>
        @endif

        <div>
            <p class="text-[10px] uppercase font-bold text-teal-400 mb-3 tracking-wider">My Account</p>
            <nav class="space-y-1">
                @if (isset($activeWelfare) && $activeWelfare)
                    <a href="{{ route('member.my-cases') }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition {{ request()->routeIs('member.my-cases') ? 'text-amber-400 font-bold' : '' }}">
                        <i class='bx bx-folder'></i> My Cases
                    </a>
                    <a href="{{ route('member.my-contributions') }}"
                        class="flex items-center gap-3 py-2 text-sm hover:text-amber-400 transition {{ request()->routeIs('member.my-contributions') ? 'text-amber-400 font-bold' : '' }}">
                        <i class='bx bx-chart'></i> My Contributions
                    </a>
                @else
                    <a href="{{ route('frontend.explore') }}"
                        class="flex items-center gap-3 py-2 text-sm text-amber-400 font-bold hover:text-white transition">
                        <i class='bx bx-search-alt'></i> Explore Welfares
                    </a>
                @endif
            </nav>
        </div>
    </div>
</aside>
