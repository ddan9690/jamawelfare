@extends('layouts.dashboard')

@section('title', 'Add New Welfare')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-teal-900">Add New Welfare</h2>
            <p class="text-stone-500 text-sm">Register a new welfare association into the system.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm">
            <form action="{{ route('welfares.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-stone-500 uppercase mb-2">Welfare Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    </div>

                    <!-- Abbreviation -->
                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase mb-2">Abbreviation</label>
                        <input type="text" name="abbreviation" value="{{ old('abbreviation') }}" required placeholder="e.g. HBMU"
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-teal-500 outline-none transition">
                    </div>

                    <!-- County -->
                    <div>
                        <label class="block text-xs font-bold text-stone-500 uppercase mb-2">County</label>
                        <select name="county_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-teal-500 outline-none transition">
                            <option value="">Select County</option>
                            @foreach($counties as $county)
                                <option value="{{ $county->id }}" {{ old('county_id') == $county->id ? 'selected' : '' }}>
                                    {{ $county->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Logo Toggle Component -->
                    <div x-data="{ hasLogo: false }" class="col-span-2">
                        <div class="mb-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="hasLogo" class="rounded text-teal-900 focus:ring-teal-900">
                                <span class="text-sm font-bold text-stone-700">Does this welfare have a logo?</span>
                            </label>
                        </div>

                        <!-- Logo Input -->
                        <div x-show="hasLogo" x-cloak class="mt-2">
                            <label class="block text-xs font-bold text-stone-500 uppercase mb-2">Upload Logo (Max 2MB)</label>
                            <input type="file" name="logo" accept="image/*"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-teal-500 outline-none transition">
                            <p class="text-[10px] text-stone-400 mt-1 uppercase font-bold tracking-widest">Supports JPG, PNG, WEBP</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-stone-500 uppercase mb-2">Description</label>
                        <textarea name="description" rows="4" 
                            class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-teal-500 outline-none transition">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button type="submit" class="bg-teal-900 hover:bg-teal-800 text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-teal-900/20">
                        Save Welfare
                    </button>
                    <a href="{{ route('welfares.index') }}" class="px-8 py-3 rounded-xl font-bold text-sm text-stone-600 hover:bg-stone-100 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection