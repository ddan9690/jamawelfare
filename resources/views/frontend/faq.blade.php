@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions')

@section('content')
<section class="py-12 md:py-20 px-4 md:px-6 bg-stone-50">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-teal-900 mb-6">Need Help?</h1>
            <p class="text-stone-600 text-lg">
                Find answers to common questions about joining and managing your welfare associations.
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ selected: null }">
            
            @php
            $faqs = [
                ['q' => 'How do I join a welfare association?', 'a' => 'Simply browse our "Explore" page to find an association that suits you. Click "View Association" to see details, and follow the registration prompts provided by the association.'],
                ['q' => 'Can I belong to multiple associations?', 'a' => 'Yes, our platform is designed to support multi-tenancy. You can manage multiple welfare memberships from a single dashboard account.'],
                ['q' => 'How is my contribution data protected?', 'a' => 'All contribution ledgers are securely encrypted. Only authorized association admins and you can view your personal contribution history.'],
                ['q' => 'What happens if I miss a contribution deadline?', 'a' => 'Each association has its own bylaws. We recommend contacting your welfare administrator directly through the contact details provided in your association dashboard.'],
                ['q' => 'How can I register my own association?', 'a' => 'We are currently onboarding associations in phases. Please reach out via our contact page, and we will guide you through the setup process.']
            ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
                <button @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null" 
                        class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                    <span class="font-black text-teal-900">{{ $faq['q'] }}</span>
                    <span class="text-teal-600 font-bold" x-text="selected === {{ $index }} ? '−' : '+'"></span>
                </button>
                <div x-show="selected === {{ $index }}" 
                     x-cloak 
                     class="px-6 pb-6 text-stone-600 leading-relaxed border-t border-stone-50 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
            <h3 class="text-lg font-black text-teal-900 mb-4">Still have questions?</h3>
            <p class="text-stone-600 mb-6">We are here to help you with anything else you need.</p>
            <a href="/contact" 
               class="inline-block bg-teal-900 text-white px-8 py-3 rounded-xl font-black hover:bg-amber-600 transition shadow-lg">
                Contact Support
            </a>
        </div>
    </div>
</section>
@endsection