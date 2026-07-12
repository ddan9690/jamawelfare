@extends('layouts.dashboard')
@section('title', 'Create New Case')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto" x-data="{ mode: 'auto', deductionMode: 'none' }">
    <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm">
        <h2 class="text-2xl font-black text-teal-900 mb-6">Create New Benevolence Case</h2>
        
        <form action="{{ route('benevolence-cases.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-stone-700 mb-3">Case Number</label>
                <div class="flex items-center gap-6 mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="number_mode" value="auto" x-model="mode" class="text-teal-900 focus:ring-teal-900">
                        <span class="ml-2 text-sm font-bold text-stone-600">Auto-Generate</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="number_mode" value="manual" x-model="mode" class="text-teal-900 focus:ring-teal-900">
                        <span class="ml-2 text-sm font-bold text-stone-600">Specify Manually</span>
                    </label>
                </div>

                <div x-show="mode === 'manual'" x-cloak>
                    <input type="text" name="case_number" placeholder="e.g. HTWA/065/01" 
                           class="w-full p-3 rounded-xl border border-stone-300 text-sm focus:border-teal-900 focus:ring-teal-900">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Select Active Member</label>
                <select name="member_id" class="select2 w-full border-stone-200 rounded-xl" required>
                    <option value="">-- Search by Name or Member Number --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->user->name }} ({{ $member->member_number }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Benevolence Category</label>
                <select name="benevolence_category_id" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }} (Ksh {{ number_format($cat->amount, 0) }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Deduct from Solidarity Fund?</label>
                <select name="deduction_mode" x-model="deductionMode" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <option value="none">No, do not deduct</option>
                    <option value="all">Yes, deduct from all active members</option>
                    <option value="except">Yes, deduct from all EXCEPT selected</option>
                </select>

                <div x-show="deductionMode === 'except'" x-cloak class="mt-4 p-4 border border-stone-200 rounded-xl bg-stone-50 max-h-60 overflow-y-auto">
                    <p class="text-xs font-bold text-stone-500 mb-2 uppercase">Exclude these members from deduction:</p>
                    @foreach($members as $member)
                        <label class="flex items-center py-1 hover:bg-stone-100 px-2 rounded cursor-pointer">
                            <input type="checkbox" name="excluded_members[]" value="{{ $member->id }}" class="rounded text-teal-900 focus:ring-teal-900">
                            <span class="ml-2 text-sm text-stone-700">{{ $member->user->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Contribution Deadline</label>
                <input type="date" name="deadline" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 mb-2">Case Details</label>
                <textarea name="details" rows="3" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required></textarea>
            </div>

            <div class="flex gap-4 mt-8">
                <a href="{{ route('benevolence-cases.index') }}" class="flex-1 py-3 text-center rounded-xl bg-stone-100 text-stone-700 font-bold text-sm">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-teal-900 text-white font-bold text-sm hover:bg-amber-600 transition">Save & Activate Case</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2({ placeholder: "Search member...", width: '100%' });
    });
</script>
@endsection