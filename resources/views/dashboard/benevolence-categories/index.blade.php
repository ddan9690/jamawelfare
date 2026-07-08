@extends('layouts.dashboard')
@section('title', 'Benevolence Categories')

@section('content')
<div x-data="{ 
    showModal: false, showEditModal: false,
    editRoute: '', editName: '', editAmount: '' 
}" class="p-4 md:p-6">

    <!-- Global Alerts -->
    @if(session('success') || session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="mb-6 p-4 rounded-xl border {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800' }}">
            <p class="text-sm font-bold">{{ session('success') ?? session('error') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-teal-900">Benevolence Categories</h2>
        <button @click="showModal = true" class="bg-teal-900 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-amber-600 transition">
            + Add New
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase text-stone-400 border-b border-stone-100">
                    <th class="py-3">Name</th> 
                    <th class="py-3">Amount</th> 
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr class="border-b last:border-0 border-stone-50">
                    <td class="py-4 font-bold text-teal-900">{{ $cat->name }}</td>
                    <td class="py-4 text-stone-600 font-medium">Ksh {{ number_format($cat->amount, 0, '.', ',') }}</td>
                    <td class="py-4 text-right space-x-3">
                        <button @click="showEditModal = true; editRoute = '{{ route('benevolence-categories.update', $cat->id) }}'; editName = '{{ $cat->name }}'; editAmount = '{{ (int)$cat->amount }}'" class="text-amber-600 font-bold hover:underline">Edit</button>
                        <form action="{{ route('benevolence-categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="py-6 text-center text-stone-400">No categories defined.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showModal = false" class="bg-white p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Create Category</h3>
            <form action="{{ route('benevolence-categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="name" placeholder="Category Name" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <input type="number" name="amount" placeholder="Amount (e.g. 500)" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 rounded-xl bg-stone-100 text-stone-700 font-bold text-sm">Cancel</button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-teal-900 text-white font-bold text-sm">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div @click.away="showEditModal = false" class="bg-white p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-lg font-black text-teal-900 mb-4">Edit Category</h3>
            <form :action="editRoute" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <input type="text" name="name" x-model="editName" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <input type="number" name="amount" x-model="editAmount" class="w-full p-3 rounded-xl border border-stone-200 text-sm" required>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="flex-1 py-3 rounded-xl bg-stone-100 text-stone-700 font-bold text-sm">Cancel</button>
                        <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-600 text-white font-bold text-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection