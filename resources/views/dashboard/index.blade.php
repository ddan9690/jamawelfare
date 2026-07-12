@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    @if(!isset($activeWelfare) || !$activeWelfare)
        <div class="max-w-2xl mx-auto mt-10 bg-white p-10 rounded-3xl border border-stone-200 text-center shadow-sm">
            <div class="text-6xl mb-6">👋</div>
            <h2 class="text-2xl font-black text-teal-900 mb-4">Welcome, {{ explode(' ', trim(auth()->user()->name))[0] }}!</h2>
            <p class="text-stone-600 mb-8 leading-relaxed">You are currently not linked to any active welfare association.</p>
            <a href="{{ route('frontend.explore') }}" class="inline-block bg-teal-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg">Explore Welfares</a>
        </div>
    @else
        <div class="mb-8"><h1 class="text-2xl font-black text-teal-900">Dashboard: {{ $activeWelfare->name }}</h1></div>

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
                    <div class="text-center"><div class="text-2xl font-black text-blue-600">{{ $stats['genders']['Male'] ?? 0 }}</div><div class="text-[9px] font-bold text-stone-500 uppercase">M</div></div>
                    <div class="text-center"><div class="text-2xl font-black text-pink-600">{{ $stats['genders']['Female'] ?? 0 }}</div><div class="text-[9px] font-bold text-stone-500 uppercase">F</div></div>
                </div>
            </div>
        </div>

        {{-- Solidarity Fund Section --}}
        <div class="mb-12" x-data="{ showInfo: false }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-black text-teal-900">Solidarity Fund</h3>
                {{-- Clickable trigger --}}
                <button @click="showInfo = true" class="text-xs font-bold text-teal-600 hover:text-teal-800 underline cursor-pointer transition">
                    What is the Solidarity Fund?
                </button>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm">
                <div class="text-3xl font-black text-teal-900 mb-6">KES {{ number_format($solidarityBalance, 2) }}</div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                            <tr><th class="py-3">Date</th><th class="py-3">Type</th><th class="py-3">Amount</th><th class="py-3">Description</th></tr>
                        </thead>
                        <tbody>
                            @forelse($solidarityTransactions as $t)
                            <tr class="border-b border-stone-50">
                                <td class="py-4">{{ $t->transaction_date->format('d M Y') }}</td>
                                <td class="py-4 font-bold {{ $t->type == 'deposit' ? 'text-emerald-600' : 'text-rose-600' }}">{{ ucfirst($t->type) }}</td>
                                <td class="py-4 font-bold">KES {{ number_format($t->amount, 0) }}</td>
                                <td class="py-4 text-stone-500">{{ $t->description }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-6 text-center text-stone-400 italic">No transactions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Educational Popup --}}
            <div x-show="showInfo" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
                <div @click.outside="showInfo = false" class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl">
                    <h3 class="text-xl font-black text-teal-900 mb-4">Understanding the Solidarity Fund</h3>
                    <p class="text-stone-600 leading-relaxed mb-6">
                        This balance is used to automatically settle your contributions toward future benevolence cases. To maintain your fund, kindly send prepayments to the designated welfare official via the official payment channels.
                        <br><br>
                        Instead of being notified to pay every time a new case arises, your share is automatically deducted from this balance, ensuring you are always compliant without manual intervention.
                    </p>
                    <button @click="showInfo = false" class="w-full py-3 bg-teal-900 text-white rounded-xl font-bold text-sm hover:bg-teal-800 transition">Understood</button>
                </div>
            </div>
        </div>

        {{-- Member Search --}}
        <div class="relative mb-12">
            <input type="text" id="memberSearch" placeholder="Search members by name, member #, or TSC..." class="w-full p-4 rounded-2xl border border-stone-200 shadow-sm focus:border-teal-500 outline-none transition">
            <div id="searchResults" class="absolute z-50 w-full bg-white mt-2 rounded-2xl shadow-xl border border-stone-100 overflow-hidden hidden"></div>
        </div>

        {{-- Active Cases & History sections follow here... --}}
    @endif
</div>
@endsection