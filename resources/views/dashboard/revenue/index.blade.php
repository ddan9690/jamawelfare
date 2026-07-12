@extends('layouts.dashboard')

@section('content')
<div class="p-4 md:p-6 max-w-7xl mx-auto" x-data="{ filter: '{{ $months }}' }">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-teal-900">Welfare Revenue Tracking</h2>
        <p class="text-stone-500 text-sm">Tracking 15% revenue share from all benevolence contributions.</p>
    </div>
    
    <form method="GET" class="mb-6 flex gap-4 items-end">
        <div>
            <label class="text-xs font-bold text-stone-500 uppercase tracking-wider mb-1 block">Time Period</label>
            <select name="months" onchange="this.form.submit()" class="block w-full md:w-48 p-3 border border-stone-200 rounded-2xl focus:ring-2 focus:ring-teal-500 outline-none font-bold text-sm">
                @foreach([1, 3, 6, 12] as $m)
                    <option value="{{ $m }}" {{ $months == $m ? 'selected' : '' }}>Last {{ $m }} Month(s)</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-stone-50 border-b border-stone-100">
                <tr>
                    <th class="p-4 font-bold text-stone-400 uppercase text-[10px]">Welfare Association</th>
                    <th class="p-4 font-bold text-stone-400 uppercase text-[10px]">Abbreviation</th>
                    <th class="p-4 font-bold text-stone-400 uppercase text-[10px] text-right">Commission Due (KES)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($data as $row)
                    <tr class="{{ $row['amount_due'] >= 10000 ? 'bg-amber-50' : '' }} transition">
                        <td class="p-4 font-black text-teal-900">{{ $row['name'] }}</td>
                        <td class="p-4 font-bold text-stone-600">{{ $row['abbreviation'] }}</td>
                        <td class="p-4 text-right font-black text-emerald-600">
                            {{ number_format((int)$row['amount_due']) }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-10 text-center text-stone-400 font-bold">No data available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')

@endpush