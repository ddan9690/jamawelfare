@extends('layouts.dashboard')
@section('title', 'Case Details')

@section('content')
<div class="p-2 md:p-6" x-data="{ showModal: false }">

    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="{{ route('benevolence-cases.index') }}" class="text-xs text-stone-500 hover:text-teal-900 font-bold">← Back to Cases</a>
    </div>

    <!-- Case Header -->
    <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm mb-6">
        <h2 class="text-2xl font-black text-teal-900">{{ $case->member->user->name }}</h2>
        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Case #{{ $case->case_number }}</p>
        <p class="text-xs font-bold text-teal-700 mt-2">Nature of Bereavement: {{ $case->category->name }}</p>
    </div>

    <!-- Contributions Table -->
    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-md font-black text-teal-900">History</h3>
                <p class="text-[11px] font-bold text-teal-700">Collected: {{ number_format($case->contributions->sum('amount'), 0) }}</p>
            </div>
            <button @click="showModal = true" class="bg-teal-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-600 transition">
                + Payment
            </button>
        </div>

        <div class="overflow-x-auto pb-2">
            <table class="w-full text-[11px]">
                <thead>
                    <tr class="text-left uppercase text-stone-400 border-b border-stone-100">
                        <th class="py-2 px-1">Mem No</th>
                        <th class="py-2 px-1">Member</th>
                        <th class="py-2 px-1">Amount</th>
                        <th class="py-2 px-1">Type</th>
                        <th class="py-2 px-1">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($case->contributions as $c)
                        <tr class="border-b border-stone-50 hover:bg-stone-50">
                            <td class="py-2 px-1 font-bold text-teal-600">{{ $c->member->member_number }}</td>
                            <td class="py-2 px-1 font-bold">{{ $c->member->user->name }}</td>
                            <td class="py-2 px-1">{{ number_format($c->amount, 0) }}</td>
                            <td class="py-2 px-1 uppercase font-bold">{{ $c->payment_type }}</td>
                            <td class="py-2 px-1 text-stone-500">{{ \Carbon\Carbon::parse($c->payment_date)->format('j-m.y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div @click.away="showModal = false" class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Record Payment</h3>
            <form id="paymentForm" action="{{ route('contributions.store', $case->id) }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="text-[10px] font-bold text-stone-400 uppercase">Member</label>
                        <select id="member_select" name="member_id" class="w-full p-2 border rounded-lg text-sm" required>
                            @foreach($membersData as $m)
                                @php
                                    $alreadyPaid = $case->contributions->where('member_id', $m['id'])->sum('amount');
                                    $target = $case->category->amount;
                                    $outstanding = $target - $alreadyPaid;
                                @endphp
                                <option value="{{ $m['id'] }}" 
                                        data-name="{{ $m['name'] }}"
                                        data-outstanding="{{ $outstanding }}">
                                    {{ $m['name'] }} (Outstanding: {{ $outstanding > 0 ? $outstanding : 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-bold text-stone-400 uppercase">Amount (Ksh)</label>
                        <input type="number" id="payment_amount" name="amount" class="w-full p-2 border rounded-lg text-sm" required>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-stone-400 uppercase">Type</label>
                            <select name="payment_type" class="w-full p-2 border rounded-lg text-sm">
                                <option value="cash">Cash</option>
                                <option value="mpesa">M-Pesa</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-stone-400 uppercase">Date</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full p-2 border rounded-lg text-sm">
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showModal = false" class="flex-1 py-2 bg-stone-100 rounded-lg font-bold text-xs">Cancel</button>
                    <button type="submit" class="flex-1 py-2 bg-teal-900 text-white rounded-lg font-bold text-xs">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#paymentForm').on('submit', function(e) {
            let option = $('#member_select').find(':selected');
            let memberName = option.data('name');
            let amount = parseFloat($('#payment_amount').val());
            let outstanding = parseFloat(option.data('outstanding'));

            if (amount > outstanding && outstanding > 0) {
                e.preventDefault();
                let excess = amount - outstanding;
                let text = `Member ${memberName} has completed the contribution for this case. The excess amount of Ksh ${excess} will be safely credited to the member's Solidarity Fund account. Proceed?`;
                
                Swal.fire({ title: 'Processing Contribution', text: text, icon: 'info', showCancelButton: true, confirmButtonColor: '#064e3b', confirmButtonText: 'Confirm' })
                .then((result) => { if (result.isConfirmed) this.submit(); });
            } else if (outstanding <= 0) {
                e.preventDefault();
                let text = `Member ${memberName} has completed the contribution for this case. The excess amount of Ksh ${amount} will be credited to the member's Solidarity Fund account. Proceed?`;
                
                Swal.fire({ title: 'Solidarity Contribution', text: text, icon: 'info', showCancelButton: true, confirmButtonColor: '#064e3b', confirmButtonText: 'Confirm' })
                .then((result) => { if (result.isConfirmed) this.submit(); });
            }
        });
    });
</script>
@endpush