@extends('layouts.dashboard')

@section('title', 'Member Directory - ' . $welfare->name)

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-teal-900">Member Directory</h1>
            <p class="text-xs text-stone-500 font-bold">Manage welfare members and track status</p>
        </div>
        <input type="text" id="memberSearch" placeholder="Search members..." 
            class="bg-white border border-stone-200 rounded-lg px-4 py-2 text-xs outline-none w-full md:w-64 focus:ring-2 focus:ring-teal-500 transition">
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left" id="memberTable">
                <thead class="text-stone-400 uppercase bg-stone-50">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Name</th>
                        <th class="px-4 py-3 whitespace-nowrap">Member #</th>
                        <th class="px-4 py-3 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 whitespace-nowrap">Balance</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    {{-- Concatenate Active and Suspended for display --}}
                    @forelse($activeMembers->concat($suspendedMembers) as $member)
                    <tr class="hover:bg-stone-50 transition {{ $member->status == 'suspended' ? 'bg-red-50/30' : '' }}">
                        <td class="px-4 py-3 font-bold text-teal-900 whitespace-nowrap">{{ $member->user->name }}</td>
                        <td class="px-4 py-3 text-stone-600 whitespace-nowrap">{{ $member->member_number ?? 'N/A' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($member->status == 'suspended')
                                <span class="px-2 py-1 bg-red-100 text-red-700 font-black text-[9px] rounded-full uppercase tracking-wider">Suspended</span>
                            @else
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 font-black text-[9px] rounded-full uppercase tracking-wider">Active</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-black text-teal-900 whitespace-nowrap">Ksh {{ number_format((int)$member->solidarity_balance) }}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <a href="{{ route('solidarity-funds.history', $member->id) }}" 
                               class="text-teal-700 font-bold hover:underline transition">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-6 text-center text-stone-400 font-bold">No members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-stone-100 bg-stone-50/50 text-[10px] text-stone-400 font-bold">
            Showing all current active and suspended members.
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('memberSearch').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection