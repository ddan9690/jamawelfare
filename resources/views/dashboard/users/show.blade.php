@extends('layouts.dashboard')
@section('content')
<div class="p-6 max-w-xl">
    <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-stone-400 hover:text-teal-900">← Back</a>
    <div class="mt-4 bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
        <h1 class="text-2xl font-black text-teal-900">{{ $user->name }}</h1>
        <div class="mt-4 space-y-2 text-sm text-stone-600">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Level:</strong> {{ $user->level }}</p>
            <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>

        <h3 class="font-bold text-teal-900 mt-6 mb-3 border-t pt-4">Welfare Memberships</h3>
        <div class="space-y-2">
            @forelse($user->welfares as $welfare)
                <div class="p-3 bg-stone-50 rounded-lg text-sm font-bold">{{ $welfare->name }}</div>
            @empty
                <p class="text-stone-400 italic">User does not belong to any welfare.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection