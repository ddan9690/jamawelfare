@extends('layouts.dashboard')
@section('title', 'My Benevolence Cases')

@section('content')
<div class="p-4 md:p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-black text-teal-900 mb-6">My Benevolence Cases</h2>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
        @forelse($cases as $case)
            <div class="p-6 border-b border-stone-100 last:border-0 hover:bg-stone-50 transition">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-teal-900">Case #{{ $case->case_number }}</h3>
                        <p class="text-sm text-stone-600 mt-1">{{ $case->details }}</p>
                        <div class="mt-3 flex gap-4 text-xs font-bold uppercase tracking-wider text-stone-500">
                            <span>Category: {{ $case->category->name }}</span>
                            <span>Deadline: {{ $case->deadline }}</span>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800 uppercase">
                        {{ $case->status }}
                    </span>
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-stone-500">
                <i class='bx bx-folder-open text-4xl mb-2'></i>
                <p>No benevolence cases found for your account.</p>
            </div>
        @endforelse
    </div>

    <!-- Report Button -->
    <div class="mt-6">
        <button onclick="alert('Redirecting to official report form...')" 
                class="bg-amber-500 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-amber-600 transition">
            Report an Issue to Officials
        </button>
    </div>
</div>
@endsection