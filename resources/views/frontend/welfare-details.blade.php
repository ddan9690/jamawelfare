@extends('layouts.frontend')

@section('content')
<section class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        
        <a href="{{ route('frontend.explore') }}" class="inline-flex items-center text-stone-500 hover:text-amber-600 mb-8 transition">
            <i class='bx bx-arrow-back mr-2'></i> Back to Explore
        </a>

        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200 mb-8">
            <span class="text-xs font-bold bg-teal-100 text-teal-900 px-3 py-1 rounded uppercase tracking-wider">
                {{ $welfare->county->name ?? 'National' }}
            </span>
            <h1 class="text-3xl md:text-4xl font-black text-teal-900 mt-4 mb-2">
                {{ $welfare->name }} <span class="text-amber-600">({{ $welfare->abbreviation }})</span>
            </h1>
        </div>

        <!-- Dynamic Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
            @auth
                @if($isMember)
                    <a href="{{ route('dashboard', [$welfare->id, $welfare->slug]) }}" 
                       class="bg-teal-900 text-white py-4 px-6 rounded-xl font-bold hover:bg-amber-600 transition flex items-center justify-center gap-2">
                        <i class='bx bx-right-arrow-circle'></i> Go to Welfare Dashboard
                    </a>
                @elseif($hasPendingRequest)
                    <button disabled class="bg-stone-200 text-stone-500 py-4 px-6 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2">
                        <i class='bx bx-check-double'></i> Request Sent
                    </button>
                @else
                    <form action="{{ route('welfares.requests.store', [$welfare->id, $welfare->slug]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-teal-900 text-white py-4 px-6 rounded-xl font-bold hover:bg-amber-600 transition flex items-center justify-center gap-2">
                            <i class='bx bx-user-plus'></i> Send Membership Request
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-teal-900 text-white py-4 px-6 rounded-xl font-bold text-center">Login to Join</a>
            @endauth
        </div>

        <!-- Content -->
        <div class="grid md:grid-cols-3 gap-12">
            <div class="md:col-span-2 space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-teal-900 mb-4">About this Association</h2>
                    <p class="text-stone-600 leading-relaxed">{{ $welfare->description }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 h-max">
                <h3 class="font-bold text-teal-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-stone-500">Members</span>
                        <span class="font-bold">{{ $welfare->members_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection