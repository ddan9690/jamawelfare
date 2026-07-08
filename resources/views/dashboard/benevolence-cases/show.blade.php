@extends('layouts.dashboard')
@section('title', 'Case Details')

@section('content')
<div class="p-4 md:p-6" x-data="{
    showModal: false,
    showEditModal: false,
    editForm: { id: '', amount: '', type: '', memberName: '', memberNo: '' }
}">

    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('benevolence-cases.index') }}" class="text-sm text-stone-500 hover:text-teal-900 font-bold">← Back to Cases</a>
    </div>

    <!-- Case Header -->
    <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-black text-teal-900">{{ $case->member->user->name }}</h2>
                <p class="text-sm font-bold text-stone-400 uppercase mt-1">Case #{{ $case->case_number }}</p>
                <p class="text-stone-600 mt-2 max-w-2xl">{{ $case->details }}</p>
                <div class="mt-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $case->status == 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-600' }}">
                        {{ $case->status }}
                    </span>
                </div>
            </div>
            <div class="text-right">
                <span class="block text-[10px] uppercase font-bold text-stone-400">Total Goal</span>
                <div class="text-2xl font-black text-stone-800">Ksh {{ number_format($case->amount_to_contribute, 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Contributions Table -->
    <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-black text-teal-900">Contribution History</h3>
                <p class="text-sm font-bold text-teal-700">Total Collected: Ksh {{ number_format($totalCollected, 0) }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('benevolence-cases.pdf', ['welfare_id' => session('active_welfare_id'), 'welfare_slug' => $case->welfare->slug, 'id' => $case->id]) }}" 
                   class="bg-stone-100 text-stone-700 px-5 py-2 rounded-xl text-sm font-bold hover:bg-stone-200 transition">
                    Export PDF
                </a>
                <button @click="showModal = true" class="bg-teal-900 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-amber-600 transition">
                    + Record Payment
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                        <th class="py-3">Mem No</th>
                        <th class="py-3">Member</th>
                        <th class="py-3">Amount</th>
                        <th class="py-3">Type</th>
                        <th class="py-3">Date</th>
                        <th class="py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($case->contributions as $c)
                        <tr class="border-b border-stone-50">
                            <td class="py-4 font-bold text-teal-600">{{ $c->member->member_number }}</td>
                            <td class="py-4 font-bold">{{ $c->member->user->name }}</td>
                            <td class="py-4">Ksh {{ number_format($c->amount, 0) }}</td>
                            <td class="py-4 uppercase text-[10px] font-bold">{{ $c->payment_type }}</td>
                            <td class="py-4 text-stone-500">{{ \Carbon\Carbon::parse($c->payment_date)->format('d M Y') }}</td>
                            <td class="py-4 text-right space-x-2">
                                <button @click="showEditModal = true; editForm = {id: '{{ $c->id }}', amount: '{{ $c->amount }}', type: '{{ $c->payment_type }}', memberName: '{{ addslashes($c->member->user->name) }}', memberNo: '{{ $c->member->member_number }}'}"
                                    class="text-blue-600 font-bold underline">Edit</button>
                                <form action="{{ route('contributions.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div @click.away="showModal = false" class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-black text-teal-900 mb-6">Record Payment</h3>
            <form action="{{ route('contributions.store', $case->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <select name="member_id" class="select2 w-full p-3 border rounded-xl" required>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->user->name }} ({{ $m->member_number }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="amount" placeholder="Amount (Ksh)" class="w-full p-3 border rounded-xl" required>
                    <select name="payment_type" class="w-full p-3 border rounded-xl" required>
                        <option value="cash">Cash</option>
                        <option value="mpesa">M-Pesa</option>
                    </select>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full p-3 border rounded-xl" required>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showModal = false" class="flex-1 py-3 bg-stone-100 rounded-xl font-bold text-sm">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-teal-900 text-white rounded-xl font-bold text-sm">Save Payment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div @click.away="showEditModal = false" class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-black text-teal-900 mb-6">Edit Payment</h3>
            <form :action="'{{ url('contributions') }}/' + editForm.id" method="POST">
                @csrf @method('PATCH')
                <div class="space-y-4">
                    <p class="text-sm font-bold text-stone-600" x-text="editForm.memberName + ' (' + editForm.memberNo + ')'"></p>
                    <input type="number" name="amount" x-model="editForm.amount" class="w-full p-3 border rounded-xl" required>
                    <select name="payment_type" x-model="editForm.type" class="w-full p-3 border rounded-xl">
                        <option value="cash">Cash</option>
                        <option value="mpesa">M-Pesa</option>
                    </select>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showEditModal = false" class="flex-1 py-3 bg-stone-100 rounded-xl font-bold text-sm">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-900 text-white rounded-xl font-bold text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({ width: '100%' });
        });
    </script>
</div>
@endsection