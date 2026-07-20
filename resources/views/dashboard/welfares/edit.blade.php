@extends('layouts.dashboard')

@section('title', 'Edit Welfare')

@section('content')
<div class="p-4 md:p-6 max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-teal-900">Edit Welfare Association</h2>
            <p class="text-sm text-stone-500">Update details for {{ $welfare->name }}</p>
        </div>
        <a href="{{ route('welfares.index') }}" class="text-sm font-bold text-teal-900 hover:text-amber-600 transition flex items-center gap-1">
            <i class='bx bx-arrow-back'></i> Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl border bg-red-50 border-red-200 text-red-800">
            <p class="text-sm font-bold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 md:p-8 rounded-3xl border border-stone-200 shadow-sm">
        <form action="{{ route('welfares.update', [$welfare->id, $welfare->slug]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold uppercase text-stone-500 mb-2">Welfare Name</label>
                    <input type="text" name="name" value="{{ old('name', $welfare->name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-stone-700 outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Abbreviation -->
                <div>
                    <label class="block text-xs font-bold uppercase text-stone-500 mb-2">Abbreviation</label>
                    <input type="text" name="abbreviation" value="{{ old('abbreviation', $welfare->abbreviation) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-stone-700 outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- County -->
                <div>
                    <label class="block text-xs font-bold uppercase text-stone-500 mb-2">County</label>
                    <select name="county_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-stone-700 outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Select County</option>
                        @foreach($counties as $county)
                            <option value="{{ $county->id }}" {{ old('county_id', $welfare->county_id) == $county->id ? 'selected' : '' }}>
                                {{ $county->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Logo Upload -->
                <div>
                    <label class="block text-xs font-bold uppercase text-stone-500 mb-2">Logo (Optional)</label>
                    <div class="flex items-center gap-4">
                        @if($welfare->logo)
                            <img src="{{ asset('storage/' . $welfare->logo) }}" class="w-10 h-10 rounded-full object-cover border border-stone-200">
                        @else
                            <img src="{{ asset('images/welfare-placeholder.svg') }}" class="w-10 h-10 rounded-full object-cover border border-stone-200">
                        @endif
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-900 hover:file:bg-teal-100">
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold uppercase text-stone-500 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-stone-700 outline-none focus:ring-2 focus:ring-teal-500">{{ old('description', $welfare->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4 pt-4 border-t border-stone-100">
                <a href="{{ route('welfares.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-sm bg-stone-100 text-stone-700 hover:bg-stone-200 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-sm bg-teal-900 text-white hover:bg-teal-800 transition">
                    Update Welfare
                </button>
            </div>
        </form>
    </div>
</div>
@endsection