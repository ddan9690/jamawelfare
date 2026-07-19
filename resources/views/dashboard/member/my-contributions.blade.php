@extends('layouts.dashboard')
@section('title', 'My Contributions')

@section('content')
<div class="p-2 md:p-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between md:items-end mb-6 px-1">
        <h2 class="text-xl font-black text-teal-900">My Contributions</h2>
        <div class="text-[10px] text-stone-400 italic">Showing your contributions and case status</div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[11px] text-left border-collapse">
                <thead class="bg-stone-50 text-stone-700 uppercase font-bold border-b border-stone-200">
                    <tr>
                        <th class="px-3 py-3 whitespace-nowrap">Case #</th>
                        <th class="px-3 py-3 whitespace-nowrap">Member</th>
                        <th class="px-3 py-3 whitespace-nowrap">Mem #</th>
                        <th class="px-3 py-3 whitespace-nowrap">Category</th>
                        <th class="px-3 py-3 whitespace-nowrap">Deadline</th>
                        <th class="px-3 py-3 whitespace-nowrap">Status</th>
                        <th class="px-3 py-3 whitespace-nowrap">Payment</th>
                        <th class="px-3 py-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($allCases as $case)
                        <tr class="hover:bg-teal-50/50 transition">
                            <td class="px-3 py-4 font-bold text-teal-900 whitespace-nowrap">{{ $case->case_number }}</td>
                            <td class="px-3 py-4 whitespace-nowrap font-medium">{{ $case->member->user->name }}</td>
                            <td class="px-3 py-4 text-stone-500 whitespace-nowrap">{{ $case->member->member_number }}</td>
                            <td class="px-3 py-4 whitespace-nowrap">{{ $case->category->name }}</td>
                            <td class="px-3 py-4 text-stone-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($case->deadline)->format('d-m-y') }}
                            </td>
                            <td class="px-3 py-4">
                                <span class="px-1.5 py-0.5 rounded bg-stone-100 text-stone-600 uppercase font-bold text-[9px] tracking-wider">
                                    {{ $case->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 font-medium whitespace-nowrap text-stone-600">
                                @if($myContributions->has($case->id))
                                    {{ ucfirst(str_replace('_', ' ', $myContributions[$case->id]->payment_type)) }}
                                @else
                                    <span class="text-stone-300">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-right font-black whitespace-nowrap">
                                @if($myContributions->has($case->id))
                                    <span class="text-green-700">{{ number_format($myContributions[$case->id]->amount, 0) }}</span>
                                @else
                                    <span class="text-red-400 italic text-[10px]">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-stone-400 italic">No cases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-1">
        {{ $allCases->links() }}
    </div>

    <!-- Footer Note -->
    <div class="mt-6 p-4 bg-teal-50 border border-teal-100 rounded-xl">
        <p class="text-[11px] text-teal-900 leading-relaxed">
            <span class="font-black block mb-1">Important Notice:</span>
            Kindly send the required amount to the designated welfare official through approved methods. If you have paid and it is not reflected, contact officials for immediate action.
        </p>
    </div>
</div>
@endsection