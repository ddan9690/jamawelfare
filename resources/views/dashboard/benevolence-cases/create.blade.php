@extends('layouts.dashboard')
@section('title', 'Create New Case')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto" x-data="{ manualCaseNumber: false }">
    <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm">
        <h2 class="text-2xl font-black text-teal-900 mb-6">Create New Benevolence Case</h2>
        
        <form action="{{ route('benevolence-cases.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Case Number Selection -->
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-3">Case Number</label>
                <div class="flex items-center gap-4 mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="number_mode" value="auto" x-model="manualCaseNumber" :value="false" class="text-teal-900 focus:ring-teal-900">
                        <span class="ml-2 text-sm font-bold text-stone-600">Auto-Generate</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="number_mode" value="manual" x-model="manualCaseNumber" :value="true" class="text-teal-900 focus:ring-teal-900">
                        <span class="ml-2 text-sm font-bold text-stone-600">Specify Manually</span>
                    </label>
                </div>

                <!-- Manual Input (Hidden by default) -->
                <div x-show="manualCaseNumber" x-cloak>
                    <input type="text" name="case_number" placeholder="Enter custom case number (e.g. HTWA/065/01)" 
                           class="w-full p-3 rounded-xl border border-stone-300 text-sm focus:border-teal-900 focus:ring-teal-900">
                </div>
            </div>

            <!-- Member Selection -->
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Select Active Member</label>
                <select name="member_id" class="select2 w-full border-stone-200 rounded-xl" required>
                    <option value="">-- Search by Name or Member Number --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->user->name }} ({{ $member->member_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category Selection -->
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Benevolence Category</label>
                <select name="benevolence_category_id" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }} (Ksh {{ number_format($cat->amount, 0) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Deadline -->
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Contribution Deadline</label>
                <input type="date" name="deadline" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
            </div>

            <!-- Details -->
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Case Details</label>
                <textarea name="details" rows="4" placeholder="Explain the situation, burial date, or call to action..." 
                          class="w-full p-3 rounded-xl border border-stone-200 text-sm" required></textarea>
            </div>

            <div class="flex gap-4 mt-8">
                <a href="{{ route('benevolence-cases.index') }}" class="flex-1 py-3 text-center rounded-xl bg-stone-100 text-stone-700 font-bold text-sm hover:bg-stone-200 transition">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-teal-900 text-white font-bold text-sm hover:bg-amber-600 transition">Save & Activate Case</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2({
            placeholder: "Search member...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection