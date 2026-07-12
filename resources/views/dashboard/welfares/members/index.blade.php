@extends('layouts.dashboard')

@section('title', 'Members - ' . $welfare->name)

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6" x-data="{ openModal: null }">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-teal-900">Member Directory</h1>
            <p class="text-xs text-stone-500 font-bold">Manage welfare members and solidarity fund balances</p>
        </div>
        <input type="text" id="memberSearch" placeholder="Search members..." 
            class="bg-white border border-stone-200 rounded-lg px-4 py-2 text-xs outline-none w-full md:w-64 focus:ring-2 focus:ring-teal-500 transition">
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left" id="memberTable">
                <thead class="text-stone-400 uppercase bg-stone-50">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">#</th>
                        <th class="px-4 py-3 whitespace-nowrap">Name</th>
                        <th class="px-4 py-3 whitespace-nowrap">Member #</th>
                        <th class="px-4 py-3 whitespace-nowrap">Phone</th>
                        <th class="px-4 py-3 whitespace-nowrap">Balance</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($activeMembers as $index => $member)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="px-4 py-3 text-stone-500 whitespace-nowrap">{{ $activeMembers->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-bold text-teal-900 whitespace-nowrap">{{ $member->user->name }}</td>
                        <td class="px-4 py-3 text-stone-600 whitespace-nowrap">{{ $member->member_number ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-stone-600 whitespace-nowrap">{{ $member->user->phone ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-black text-teal-900 whitespace-nowrap">Ksh {{ number_format((int)$member->solidarity_balance) }}</td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <button @click="openModal = {{ $member->id }}" 
                                class="text-teal-700 font-bold hover:underline transition">Update balance</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-6 text-center text-stone-400 font-bold">No active members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-stone-100 bg-stone-50/50">
            {{ $activeMembers->links() }}
        </div>
    </div>

    @foreach($activeMembers as $member)
    <div x-show="openModal === {{ $member->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div @click.outside="openModal = null" class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-2xl">
            <h2 class="text-lg font-black text-teal-900 mb-1">Solidarity Fund</h2>
            <div class="mb-4 text-stone-500 text-xs font-medium space-y-1">
                <p>Member: <span class="font-bold text-stone-800">{{ $member->user->name }}</span></p>
                <p>Member Number: <span class="font-bold text-stone-800">{{ $member->member_number }}</span></p>
                <p class="text-teal-900 font-black text-sm pt-2">Current Balance: Ksh {{ number_format((int)$member->solidarity_balance) }}</p>
            </div>
            
            <form action="{{ route('solidarity-funds.store') }}" method="POST">
                @csrf
                <input type="hidden" name="welfare_member_id" value="{{ $member->id }}">
                <div class="space-y-3">
                    <input type="number" name="amount" placeholder="Deposit Amount (Ksh)" 
                        class="w-full p-2 rounded-lg border border-stone-200 text-sm focus:ring-2 focus:ring-teal-500 outline-none" required>
                    <select name="payment_method" class="w-full p-2 rounded-lg border border-stone-200 text-sm">
                        <option value="mpesa">M-Pesa</option>
                        <option value="cash">Cash</option>
                        <option value="bank">Bank</option>
                    </select>
                    <input type="text" name="reference_number" placeholder="Transaction Code" 
                        class="w-full p-2 rounded-lg border border-stone-200 text-sm">
                    <button type="submit" class="w-full bg-teal-900 text-white py-2 rounded-lg font-bold text-sm hover:bg-amber-600 transition">Confirm Deposit</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

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