@extends('layouts.dashboard')
@section('title', 'Benevolence Cases')

@section('content')
<div x-data="{ 
    showDetails: false, modalDetails: '', 
    showExtend: false, extendRoute: '',
    showStatus: false, statusRoute: '', currentStatus: ''
}" class="p-4 md:p-8 max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-black text-teal-900">Benevolence Cases</h2>
            <p class="text-stone-500 font-bold mt-1">Manage and track active welfare support cases.</p>
        </div>
        <a href="{{ route('benevolence-cases.create') }}" class="bg-teal-900 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-amber-600 transition shadow-lg">+ New Case</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($cases as $case)
        <div class="bg-white rounded-3xl border border-stone-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col">
            
            {{-- Card Header & Status --}}
            <div class="bg-stone-50 p-5 border-b border-stone-100">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-black uppercase text-teal-900 tracking-wider">Case {{ $case->case_number }}</span>
                    <a href="{{ route('benevolence-cases.show', $case->id) }}" class="text-[10px] font-bold bg-teal-100 text-teal-800 px-3 py-1 rounded-full hover:bg-teal-200">VIEW</a>
                </div>
                <span @class(['px-3 py-1 rounded-full text-[10px] font-black uppercase', 'bg-emerald-100 text-emerald-700' => $case->status == 'active', 'bg-amber-100 text-amber-700' => $case->status == 'closed', 'bg-red-100 text-red-700' => $case->status == 'suspended'])>
                    {{ $case->status }}
                </span>
            </div>

            {{-- Card Body --}}
            <div class="p-5 flex-grow space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase">Member Name</p>
                        <p class="font-black text-teal-900">{{ $case->member->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase">Member #</p>
                        <p class="font-black text-teal-600">{{ $case->member->member_number }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-stone-400 uppercase">Affected Family Member</p>
                    <p class="text-sm font-bold text-stone-700">{{ $case->category->name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 items-end">
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase">Contribution</p>
                        <p class="text-sm font-black text-emerald-600">KES {{ number_format($case->amount_to_contribute, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase">Deadline</p>
                        <p class="text-sm font-bold text-stone-600">{{ \Carbon\Carbon::parse($case->deadline)->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Actions --}}
            <div class="p-4 bg-stone-50 border-t border-stone-100 grid grid-cols-1 gap-2">
                <button @click="showStatus = true; statusRoute = '{{ route('benevolence-cases.update-status', $case->id) }}'; currentStatus = '{{ $case->status }}'" class="w-full text-[11px] font-bold text-white bg-teal-700 py-2.5 rounded-lg hover:bg-teal-800">Change Status</button>
                <button @click="showExtend = true; extendRoute = '{{ route('benevolence-cases.extend', $case->id) }}'" class="w-full text-[11px] font-bold text-white bg-blue-600 py-2.5 rounded-lg hover:bg-blue-700">Extend Deadline</button>
                <form action="{{ route('benevolence-cases.destroy', $case->id) }}" method="POST" onsubmit="return confirm('Delete this case?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full text-[11px] font-bold text-white bg-red-600 py-2.5 rounded-lg hover:bg-red-700">Delete Case</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-stone-200">
            <p class="text-stone-400 font-bold">No benevolence cases found at the moment.</p>
        </div>
        @endforelse
    </div>

    {{-- Modals --}}
    <div x-show="showDetails" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showDetails = false" class="bg-white p-6 rounded-2xl w-full max-w-lg shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Case Details</h3>
            <p class="text-stone-600 text-sm whitespace-pre-line" x-text="modalDetails"></p>
            <button @click="showDetails = false" class="mt-6 w-full py-3 rounded-xl bg-stone-100 font-bold text-sm">Close</button>
        </div>
    </div>

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

    <div x-show="showStatus" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showStatus = false" class="bg-white p-6 rounded-2xl w-full max-w-xs shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Change Status</h3>
            <form :action="statusRoute" method="POST">
                @csrf @method('PATCH')
                <div class="space-y-2">
                    @foreach(['active', 'closed', 'suspended'] as $s)
                        <label class="flex items-center p-3 rounded-xl border border-stone-200 cursor-pointer hover:bg-stone-50">
                            <input type="radio" name="status" value="{{ $s }}" :checked="currentStatus == '{{ $s }}'" class="text-teal-900">
                            <span class="ml-3 text-sm font-bold capitalize">{{ $s }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showStatus = false" class="flex-1 py-3 rounded-xl bg-stone-100 font-bold text-sm">Cancel</button>
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-teal-900 text-white font-bold text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection