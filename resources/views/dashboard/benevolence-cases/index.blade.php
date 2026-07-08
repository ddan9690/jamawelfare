@extends('layouts.dashboard')
@section('title', 'Benevolence Cases')

@section('content')
<div x-data="{ 
    showDetails: false, 
    modalDetails: '', 
    showExtend: false,
    extendRoute: ''
}" class="p-4 md:p-6">

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-teal-900">Benevolence Cases</h2>
        <a href="{{ route('benevolence-cases.create') }}" class="bg-teal-900 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-amber-600 transition">+ New Case</a>
    </div>

    <!-- Table -->
    <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                    <th class="py-3">Case No.</th> <!-- Added Column -->
                    <th class="py-3">Mem No.</th> 
                    <th class="py-3">Member</th> 
                    <th class="py-3">Category</th> 
                    <th class="py-3">Amount</th> 
                    <th class="py-3">Deadline</th> 
                    <th class="py-3">Status</th> 
                    <th class="py-3">Details</th> 
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cases as $case)
                <tr class="border-b border-stone-50">
                    <td class="py-4 font-bold text-stone-800">{{ $case->case_number }}</td> <!-- Added Data -->
                    <td class="py-4 font-bold text-teal-600">{{ $case->member->member_number }}</td>
                    <td class="py-4 font-bold text-teal-900">
                        <a href="{{ route('benevolence-cases.show', $case->id) }}" class="hover:text-teal-600 hover:underline">
                            {{ $case->member->user->name }}
                        </a>
                    </td>
                    <td class="py-4 text-stone-600">{{ $case->category->name }}</td>
                    <td class="py-4 text-stone-600">Ksh {{ number_format($case->amount_to_contribute, 0) }}</td>
                    <td class="py-4 text-stone-500">{{ \Carbon\Carbon::parse($case->deadline)->format('d M Y') }}</td>
                    <td class="py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $case->status == 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-600' }}">
                            {{ $case->status }}
                        </span>
                    </td>
                    <td class="py-4">
                        <button @click="showDetails = true; modalDetails = `{{ addslashes($case->details) }}`" class="text-teal-600 font-bold underline">View</button>
                    </td>
                    <td class="py-4 text-right space-x-2">
                        <button @click="showExtend = true; extendRoute = '{{ route('benevolence-cases.extend', $case->id) }}'" class="text-blue-600 font-bold hover:underline">Extend</button>
                        <form action="{{ route('benevolence-cases.destroy', $case->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this case?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="py-6 text-center text-stone-400">No active cases found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Details Modal -->
    <div x-show="showDetails" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showDetails = false" class="bg-white p-6 rounded-2xl w-full max-w-lg shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Case Details</h3>
            <p class="text-stone-600 text-sm whitespace-pre-line" x-text="modalDetails"></p>
            <button @click="showDetails = false" class="mt-6 w-full py-3 rounded-xl bg-stone-100 font-bold text-sm">Close</button>
        </div>
    </div>

    <!-- Extend Deadline Modal -->
    <div x-show="showExtend" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showExtend = false" class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Extend Deadline</h3>
            <form :action="extendRoute" method="POST">
                @csrf @method('PATCH')
                <label class="block text-xs font-bold text-stone-500 mb-2">Select New Deadline</label>
                <input type="date" name="new_deadline" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showExtend = false" class="flex-1 py-3 rounded-xl bg-stone-100 font-bold text-sm">Cancel</button>
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-teal-900 text-white font-bold text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection