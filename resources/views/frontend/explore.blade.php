@extends('layouts.frontend')

@section('title', 'Explore Welfare Associations')

@section('content')
<section class="py-12 md:py-20 px-4 md:px-6 bg-stone-50" x-data="{ 
    search: '', 
    selectedCounty: 'All',
    showModal: false,
    modalTitle: '',
    modalDesc: ''
}">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-teal-900 mb-6">Discover Your Welfare</h1>
            <p class="text-stone-600 max-w-2xl mx-auto text-lg px-4">
                Join a professional community that supports your journey. Browse our network of associations across Kenya.
            </p>
        </div>

        <!-- Search & Filter Bar -->
        <div class="max-w-4xl mx-auto mb-12 flex flex-col md:flex-row gap-4 bg-white p-3 rounded-2xl shadow-sm border border-stone-100">
            <div class="flex-grow relative">
                <input type="text" x-model="search" placeholder="Search by name or abbreviation..." 
                       class="w-full px-6 py-4 rounded-xl outline-none bg-stone-50 border border-stone-100 focus:ring-2 focus:ring-teal-500 transition">
            </div>
            <select x-model="selectedCounty" class="px-6 py-4 rounded-xl border border-stone-100 bg-stone-50 outline-none focus:ring-2 focus:ring-teal-500 font-bold text-stone-700 cursor-pointer">
                <option value="All">All Counties</option>
                @foreach($counties as $county)
                    <option value="{{ $county->name }}">{{ $county->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Welfare Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($welfares as $w)
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
                 x-show="(selectedCounty === 'All' || '{{ $w->county->name ?? '' }}' === selectedCounty) && 
                         ('{{ strtolower($w->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($w->abbreviation) }}'.includes(search.toLowerCase()))">
                
                <div class="flex items-start justify-between mb-6">
                    @if($w->logo)
                        <img src="{{ asset('storage/' . $w->logo) }}" class="w-16 h-16 rounded-2xl shadow-sm object-cover border border-stone-100">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-stone-100 flex items-center justify-center text-stone-400 font-black">
                            {{ substr($w->abbreviation, 0, 2) }}
                        </div>
                    @endif
                    <span class="text-[10px] font-black bg-teal-50 text-teal-700 px-3 py-1 rounded-full uppercase tracking-widest">
                        {{ $w->county->name ?? 'National' }}
                    </span>
                </div>
                
                <h3 class="text-xl font-black text-teal-900 leading-snug mb-3 group-hover:text-teal-700 transition">
                    {{ $w->name }} 
                    <span class="text-amber-600 block text-sm font-bold">({{ $w->abbreviation }})</span>
                </h3>
                
                <p class="text-stone-600 mb-8 flex-grow leading-relaxed">
                    {{ \Illuminate\Support\Str::words($w->description, 35, '...') }}
                    @if(\Illuminate\Support\Str::wordCount($w->description) > 35)
                        <button @click="showModal = true; modalTitle = '{{ addslashes($w->name) }}'; modalDesc = '{{ str_replace(["\r", "\n"], ' ', addslashes($w->description)) }}'" 
                                class="text-teal-900 font-black hover:underline block mt-2 text-sm">Read full details &rarr;</button>
                    @endif
                </p>
                
                <a href="{{ route('frontend.welfare.details', [$w->id, $w->slug]) }}" 
                   class="w-full text-center bg-teal-900 text-white py-4 rounded-xl font-black hover:bg-teal-800 transition shadow-lg shadow-teal-900/20">
                    View Association
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for Read More -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white p-8 md:p-10 rounded-3xl max-w-lg w-full shadow-2xl" @click.away="showModal = false">
            <h3 class="text-2xl font-black text-teal-900 mb-4" x-text="modalTitle"></h3>
            <p class="text-stone-600 leading-relaxed mb-8 max-h-96 overflow-y-auto" x-text="modalDesc"></p>
            <button @click="showModal = false" class="w-full py-4 bg-stone-100 hover:bg-stone-200 rounded-xl font-bold transition">Close</button>
        </div>
    </div>
</section>
@endsection