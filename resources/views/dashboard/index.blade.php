@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    
    {{-- Empty State --}}
    @if(!isset($activeWelfare) || !$activeWelfare)
        <div class="max-w-2xl mx-auto mt-10 bg-white p-10 rounded-3xl border border-stone-200 text-center shadow-sm">
            <div class="text-6xl mb-6">👋</div>
            <h2 class="text-2xl font-black text-teal-900 mb-4">Welcome, {{ explode(' ', trim(auth()->user()->name))[0] }}!</h2>
            <p class="text-stone-600 mb-8 leading-relaxed">
                You are currently not linked to any active welfare association. 
            </p>
            <a href="{{ route('frontend.explore') }}" 
               class="inline-block bg-teal-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg">
                Explore Welfares
            </a>
        </div>
    @else
        
        <div class="mb-8">
            <h1 class="text-2xl font-black text-teal-900">Dashboard: {{ $activeWelfare->name }}</h1>
        </div>

        {{-- Statistics Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
                <div class="text-stone-400 text-[10px] font-bold uppercase mb-2">Active Cases</div>
                <div class="text-3xl font-black text-emerald-600">{{ $activeWelfare->benevolenceCases()->where('status', 'active')->count() }}</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm col-span-2">
                <h3 class="text-xs font-bold text-stone-400 uppercase mb-4">Members by Level</h3>
                <div class="flex justify-between gap-4">
                    @foreach(['Primary', 'Junior School', 'Senior School', 'Tertiary'] as $level)
                        <div class="text-center">
                            <div class="text-2xl font-black text-teal-900">{{ $stats['levels'][$level] ?? 0 }}</div>
                            <div class="text-[9px] font-bold text-stone-500 uppercase">{{ $level }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
                <h3 class="text-xs font-bold text-stone-400 uppercase mb-4">Gender</h3>
                <div class="flex justify-around">
                    <div class="text-center">
                        <div class="text-2xl font-black text-blue-600">{{ $stats['genders']['Male'] ?? 0 }}</div>
                        <div class="text-[9px] font-bold text-stone-500 uppercase">M</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-black text-pink-600">{{ $stats['genders']['Female'] ?? 0 }}</div>
                        <div class="text-[9px] font-bold text-stone-500 uppercase">F</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Member Search --}}
        <div class="relative mb-12">
            <input type="text" id="memberSearch"
                   placeholder="Search members by name, member #, or TSC..." 
                   class="w-full p-4 rounded-2xl border border-stone-200 shadow-sm focus:border-teal-500 outline-none transition">
            <div id="searchResults" class="absolute z-50 w-full bg-white mt-2 rounded-2xl shadow-xl border border-stone-100 overflow-hidden hidden"></div>
        </div>
        
        {{-- Benevolence Cases --}}
        <div class="mb-12" x-data="{ openModal: null }">
            <h3 class="text-lg font-black text-teal-900 mb-4">Active Benevolence Cases</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($activeCases as $case)
                    <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm flex flex-col">
                        <div class="text-[10px] font-bold text-teal-600 uppercase">Case #{{ $case->case_number }}</div>
                        <h4 class="text-lg font-black text-stone-800 mt-1">{{ $case->member->user->name }}</h4>
                        <p class="text-xs font-bold text-stone-400 mb-4">Member No: {{ $case->member->member_number }}</p>
                        <button @click="openModal = {{ $case->id }}" class="mt-auto text-sm font-bold text-teal-900 underline self-start">View Details</button>
                    </div>

                    {{-- Modal --}}
                    <div x-show="openModal === {{ $case->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
                        <div @click.outside="openModal = null" class="bg-white p-8 rounded-3xl w-full max-w-lg shadow-2xl">
                            <h3 class="text-xl font-black text-teal-900 mb-4">Case #{{ $case->case_number }}</h3>
                            <p class="text-stone-700 leading-relaxed bg-stone-50 p-4 rounded-xl">{{ $case->details }}</p>
                            <button @click="openModal = null" class="mt-6 w-full py-3 bg-stone-100 rounded-xl font-bold text-sm">Close</button>
                        </div>
                    </div>
                @empty
                    <p class="text-stone-500 italic col-span-full">No active benevolence cases.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $activeCases->links() }}</div>
        </div>
        
        {{-- Contribution History --}}
        <div class="mt-8">
            <h3 class="text-lg font-black text-teal-900 mb-4">My Contributions History</h3>
            <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                            <th class="py-3">Case</th>
                            <th class="py-3">Member</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myContributions as $c)
                        <tr class="border-b border-stone-50">
                            <td class="py-4 font-bold">{{ $c->case->case_number }}</td>
                            <td class="py-4 font-bold text-teal-900">{{ $c->case->member->user->name }}</td>
                            <td class="py-4 text-teal-600 font-bold">Ksh {{ number_format($c->amount, 0) }}</td>
                            <td class="py-4 text-stone-500">{{ \Carbon\Carbon::parse($c->payment_date)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-6 text-center text-stone-400">No records.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#memberSearch').on('keyup', function() {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: `/welfare/{{ $activeWelfare->id ?? 0 }}/members/search`,
                data: { q: query },
                success: function(data) {
                    let container = $('#searchResults').removeClass('hidden').empty();
                    data.forEach(m => {
                        container.append(`<div class="p-4 border-b hover:bg-stone-50">${m.user.name} - ${m.member_number}</div>`);
                    });
                }
            });
        }
    });
});
</script>
@endpush