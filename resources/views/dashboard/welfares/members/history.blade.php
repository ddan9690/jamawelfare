@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto p-6" x-data="{ openModal: false, txId: null, txAmount: '', txDesc: '' }">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-black text-teal-900">{{ $member->user->name }}</h2>
            <p class="text-xs text-stone-500 font-bold">Member #: {{ $member->member_number }}</p>
        </div>
        <button @click="openModal = true; txId = null; txAmount = ''; txDesc = ''" 
                class="bg-teal-900 text-white px-4 py-2 rounded-lg font-bold text-xs hover:bg-amber-600 transition">
            + New Payment
        </button>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden">
        <table class="w-full text-xs text-left">
            <thead class="text-stone-400 uppercase bg-stone-50">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Description</th>
                    <th class="p-3 text-right">Amount</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($transactions as $tx)
                <tr>
                    <td class="p-3">{{ $tx->transaction_date->format('d M Y') }}</td>
                    <td class="p-3">{{ $tx->description }}</td>
                    <td class="p-3 text-right font-bold">Ksh {{ number_format($tx->amount) }}</td>
                    <td class="p-3">
                        <button @click="openModal = true; txId = '{{ $tx->id }}'; txAmount = '{{ $tx->amount }}'; txDesc = '{{ $tx->description }}'"
                                class="text-blue-600 font-bold underline">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal (Used for Create & Edit) -->
    <div x-show="openModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" x-cloak>
        <div @click.outside="openModal = false" class="bg-white p-6 rounded-2xl w-full max-w-sm">
            <h3 class="font-black text-teal-900 mb-1" x-text="txId ? 'Edit Transaction' : 'New Payment'"></h3>
            <p class="text-xs text-stone-500 mb-4">{{ $member->user->name }}</p>
            
            <form action="{{ route('solidarity-funds.store') }}" method="POST">
                @csrf
                <input type="hidden" name="welfare_member_id" value="{{ $member->id }}">
                <input type="hidden" name="transaction_id" x-model="txId">
                
                <div class="space-y-3">
                    <input type="number" name="amount" x-model="txAmount" placeholder="Amount (Ksh)" class="w-full p-2 border border-stone-200 rounded-lg text-sm" required>
                    <input type="text" name="description" x-model="txDesc" placeholder="Description" class="w-full p-2 border border-stone-200 rounded-lg text-sm" required>
                    
                    <button type="submit" class="w-full bg-teal-900 text-white py-2 rounded-lg font-bold">
                        Save Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection