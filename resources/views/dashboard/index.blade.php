@extends('layouts.dashboard')

@section('content')
<div class="p-4 md:p-6 max-w-7xl mx-auto" id="dashboardContent">
    @if(!isset($activeWelfare) || !$activeWelfare)
        <div class="max-w-2xl mx-auto mt-10 bg-white p-10 rounded-3xl border border-stone-200 text-center shadow-sm">
            <div class="text-6xl mb-6">👋</div>
            <h2 class="text-2xl font-black text-teal-900 mb-4">Welcome, {{ explode(' ', trim(auth()->user()->name))[0] }}!</h2>
            <p class="text-stone-600 mb-8 leading-relaxed">You are currently not linked to any active welfare association.</p>
            <a href="{{ route('frontend.explore') }}" class="inline-block bg-teal-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg">Explore Welfares</a>
        </div>
    @else
        
        {{-- Suspended Warning --}}
        @if(auth()->user()->welfareMember && auth()->user()->welfareMember->status == 'suspended')
            <div class="bg-red-600 p-8 rounded-3xl mb-8 border-4 border-red-800 shadow-2xl">
                <h2 class="text-white text-3xl font-black mb-2 uppercase tracking-tight">Membership Suspended</h2>
                <p class="text-red-100 font-bold text-lg mb-6">Your membership is suspended due to missed contributions. Please contact welfare officials.</p>
            </div>
        @endif

        {{-- Welfare Header Section --}}
        <div class="mb-8 flex flex-col items-center text-center">
            @if(!empty($activeWelfare->logo))
                <img src="{{ asset('storage/' . $activeWelfare->logo) }}" alt="{{ $activeWelfare->name }}" class="w-20 h-20 object-cover rounded-full border-4 border-teal-50 shadow-md mb-4">
            @endif
            <h1 class="text-2xl font-black text-teal-900">{{ $activeWelfare->name }}</h1>
            <span class="text-sm font-bold text-teal-700 bg-teal-50 px-3 py-1 rounded-full mt-2 mb-4">{{ $activeWelfare->abbreviation }}</span>
            
            {{-- Member Info Block --}}
            <div class="bg-stone-50 px-6 py-3 rounded-2xl border border-stone-100 text-left">
                <div class="text-[10px] uppercase font-black text-stone-400">My Details</div>
                <div class="flex gap-6">
                    <div>
                        <div class="text-[9px] uppercase font-bold text-stone-500">Name</div>
                        <div class="text-sm font-black text-teal-900">{{ auth()->user()->name }}</div>
                    </div>
                    <div>
                        <div class="text-[9px] uppercase font-bold text-stone-500">Member #</div>
                        <div class="text-sm font-black text-teal-900">{{ auth()->user()->welfareMember->member_number ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->is_super_admin || $activeMemberRole === 'admin')
            <div class="relative mb-8">
                <input type="text" id="liveSearch" placeholder="Search members, cases, or details..." 
                    class="w-full p-4 rounded-2xl border border-stone-200 shadow-sm focus:ring-2 focus:ring-teal-500 outline-none transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 searchable-section">
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
                    <div class="text-stone-400 text-[10px] font-bold uppercase mb-2">Active Cases</div>
                    <div class="text-3xl font-black text-emerald-600">{{ $activeWelfare->benevolenceCases()->where('status', 'active')->count() }}</div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm col-span-2">
                    <h3 class="text-xs font-bold text-stone-400 uppercase mb-4">Members by Level</h3>
                    <div class="flex justify-between gap-4">
                        @foreach(['Primary', 'Junior', 'Senior', 'Tertiary'] as $level)
                            <div class="text-center">
                                <div class="text-xl md:text-2xl font-black text-teal-900">{{ $stats['levels'][$level] ?? 0 }}</div>
                                <div class="text-[9px] font-bold text-stone-500 uppercase">{{ $level }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
                    <h3 class="text-xs font-bold text-stone-400 uppercase mb-4">Gender</h3>
                    <div class="flex justify-around">
                        <div class="text-center"><div class="text-2xl font-black text-blue-600">{{ $stats['genders']['Male'] ?? 0 }}</div><div class="text-[9px] font-bold text-stone-500 uppercase">M</div></div>
                        <div class="text-center"><div class="text-2xl font-black text-pink-600">{{ $stats['genders']['Female'] ?? 0 }}</div><div class="text-[9px] font-bold text-stone-500 uppercase">F</div></div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Solidarity Fund Section --}}
        <div class="mb-12 searchable-section">
            <h3 class="text-lg font-black text-teal-900 mb-4">Solidarity Fund</h3>
            <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm">
                <div class="text-stone-400 text-[10px] font-bold uppercase mb-1">Current Balance</div>
                <div class="text-3xl font-black text-teal-900 mb-6">Ksh {{ number_format((int)$solidarityBalance) }}</div>
                
                @if($solidarityTransactions->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase text-stone-400 border-b border-stone-100">
                                <tr><th class="py-3 px-4">Date</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Amount</th><th class="py-3 px-4">Description</th></tr>
                            </thead>
                            <tbody class="divide-y divide-stone-50">
                                @foreach($solidarityTransactions as $t)
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap">{{ $t->transaction_date->format('d-m-y') }}</td>
                                    <td class="py-4 px-4 font-bold {{ $t->type == 'deposit' ? 'text-emerald-600' : 'text-rose-600' }}">{{ ucfirst($t->type) }}</td>
                                    <td class="py-4 px-4 font-bold">KES {{ number_format((int)$t->amount) }}</td>
                                    <td class="py-4 px-4 text-stone-500">{{ $t->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-stone-400 text-sm font-bold italic py-4">No transactions found.</p>
                @endif
            </div>
        </div>

        {{-- Active Cases Section --}}
        <div class="mb-12 searchable-section">
            <h3 class="text-lg font-black text-teal-900 mb-6">Active Benevolence Cases</h3>
            @if($activeCases->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeCases as $case)
                        <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm">
                            <div class="flex justify-between mb-2">
                                <span class="text-[10px] font-black uppercase text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Active</span>
                                <span class="text-[10px] font-bold text-stone-400">{{ $case->created_at->format('d-m-y') }}</span>
                            </div>
                            <h4 class="font-bold text-teal-900">{{ $case->member->user->name }}</h4>
                            <p class="text-xs text-stone-600">{{ $case->description }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-stone-500 font-bold bg-stone-100 p-6 rounded-2xl text-center">No active benevolence cases for now.</p>
            @endif
        </div>
    @endif
</div>

@push('scripts')
<script>
    const searchBar = document.getElementById('liveSearch');
    if (searchBar) {
        searchBar.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let sections = document.querySelectorAll('.searchable-section');
            sections.forEach(section => {
                section.style.display = section.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    }
</script>
@endpush
@endsection