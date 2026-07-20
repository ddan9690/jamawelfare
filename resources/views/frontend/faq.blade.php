@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions')
@section('meta_description', 'Find answers to common questions about joining welfare associations, managing contributions, and using the JamaWelfare digital platform for Kenyan educators.')

@section('content')
<section class="py-12 md:py-20 px-4 md:px-6 bg-stone-50">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-teal-900 mb-6">Need Help?</h1>
            <p class="text-stone-600 text-lg">
                Find answers to common questions about joining, participating, and managing your welfare associations on JamaWelfare.
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ selected: 0 }">
            
            @php
            $faqs = [
                [
                    'q' => 'How do I join a welfare association?', 
                    'a' => 'To join a welfare, head over to the Explore section, search for the specific association you wish to join, and submit a membership request. Once sent, the respective welfare officials will review your request and notify you once it is approved.'
                ],
                [
                    'q' => 'Can I belong to multiple welfare associations?', 
                    'a' => 'Yes, absolutely. JamaWelfare is designed to allow users to be part of different groups. You can easily manage, view contributions, and participate in multiple welfare associations from a single dashboard account.'
                ],
                [
                    'q' => 'How do welfare officials register and onboard their association?', 
                    'a' => 'Welfare officials (Chairpersons, Treasurers, Secretaries) looking to digitize their groups can initiate the process by contacting us via our Request Demo or Contact page. Our team will guide you through a quick setup to get your members and contributions onto the platform.'
                ]
            ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <button @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null" 
                        class="w-full text-left p-6 flex justify-between items-center focus:outline-none hover:bg-stone-50/50"
                        type="button"
                        aria-expanded="selected === {{ $index }}"
                        aria-controls="faq-{{ $index }}">
                    <span class="font-black text-teal-900 pr-4">{{ $faq['q'] }}</span>
                    <span class="text-teal-600 font-bold text-2xl transition-transform duration-200" 
                          x-bind:class="selected === {{ $index }} ? 'rotate-180' : ''"
                          aria-hidden="true">+</span>
                </button>
                <div id="faq-{{ $index }}"
                     x-show="selected === {{ $index }}" 
                     x-cloak 
                     x-collapse
                     class="px-6 pb-6 text-stone-600 leading-relaxed border-t border-stone-100 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
            <h3 class="text-2xl font-black text-teal-900 mb-4">Still have questions?</h3>
            <p class="text-stone-600 mb-8 max-w-md mx-auto">Can't find the answer you're looking for? Our support team is ready to assist you.</p>
            <a href="/contact" 
               class="inline-block bg-teal-900 text-white px-8 py-4 rounded-xl font-black hover:bg-amber-600 transition shadow-lg text-lg">
                Contact Us Directly
            </a>
        </div>
    </div>
</section>

<!-- Alpine 'cloak' and collapse scripts -->
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/collapse.min.js"></script>
@endpush