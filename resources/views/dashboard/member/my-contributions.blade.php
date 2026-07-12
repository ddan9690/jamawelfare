@extends('layouts.dashboard')
@section('title', 'My Contributions')

@section('content')
<div class="p-4 md:p-6 max-w-6xl mx-auto">
    <div class="flex justify-between items-end mb-6">
        <h2 class="text-xl font-black text-teal-900">My Contributions</h2>
        <div class="text-xs text-stone-500 italic">Showing your contributions and case status</div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm">
        <table class="w-full text-[11px] text-left">
            <thead class="bg-stone-50 text-stone-700 uppercase font-bold border-b border-stone-200">
                <tr>
                    <th class="px-3 py-3">Case #</th>
                    <th class="px-3 py-3">Affected Member</th>
                    <th class="px-3 py-3">Mem #</th>
                    <th class="px-3 py-3">Category</th>
                    <th class="px-3 py-3">Deadline</th>
                    <th class="px-3 py-3">Status</th>
                    <th class="px-3 py-3">Payment Type</th>
                    <th class="px-3 py-3 text-right">Paid Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($allCases as $case)
                    <tr class="hover:bg-teal-50 transition">
                        <td class="px-3 py-3 font-bold text-teal-900 whitespace-nowrap">{{ $case->case_number }}</td>
                        <td class="px-3 py-3 whitespace-nowrap">{{ $case->member->user->name }}</td>
                        <td class="px-3 py-3 text-stone-500 whitespace-nowrap">{{ $case->member->member_number }}</td>
                        <td class="px-3 py-3 whitespace-nowrap">{{ $case->category->name }}</td>
                        <!-- Format Date as DD-MM-YY -->
                        <td class="px-3 py-3 text-stone-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($case->deadline)->format('d-m-y') }}
                        </td>
                        <td class="px-3 py-3">
                            <span class="px-1.5 py-0.5 rounded bg-stone-100 text-stone-600 uppercase font-bold text-[9px]">
                                {{ $case->status }}
                            </span>
                        </td>
                        <td class="px-3 py-3 font-medium whitespace-nowrap">
                            @if($myContributions->has($case->id))
                                {{ ucfirst(str_replace('_', ' ', $myContributions[$case->id]->payment_type)) }}
                            @else
                                <span class="text-stone-300">-</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-right font-black whitespace-nowrap">
                            @if($myContributions->has($case->id))
                                <span class="text-green-700">Ksh {{ number_format($myContributions[$case->id]->amount, 0) }}</span>
                            @else
                                <span class="text-red-500 italic text-[10px]">No contribution</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-stone-500 italic">No cases found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $allCases->links() }}
    </div>

    <!-- Footer Note -->
    <div class="mt-8 p-4 bg-teal-50 border border-teal-100 rounded-xl">
        <p class="text-xs text-teal-900 leading-relaxed">
            <span class="font-bold block mb-1">Important Notice:</span>
            To make a payment for an active case, kindly send the required amount to the designated welfare official through the approved payment method. 
            If you have made a payment for a case and it has not been reflected here, kindly contact the officials for immediate action.
        </p>
    </div>
</div>
@endsection