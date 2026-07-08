@extends('layouts.frontend')

@section('title', 'Get in Touch')

@section('content')
<section class="py-12 md:py-20 px-4 md:px-6 bg-stone-50">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-teal-900 mb-6">Let's Connect</h1>
            <p class="text-stone-600 max-w-xl mx-auto text-lg">
                Have questions about a welfare association or need assistance with your platform? Our support team is ready to help.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Contact Details Card -->
            <div class="bg-white p-8 md:p-10 rounded-3xl border border-stone-100 shadow-sm flex flex-col">
                <h2 class="text-2xl font-black text-teal-900 mb-8">Contact Information</h2>
                
                <div class="space-y-6">
                    <!-- WhatsApp Button -->
                    <div>
                        <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Instant Chat</p>
                        <a href="https://wa.me/254711317235" target="_blank" 
                           class="flex items-center justify-center gap-3 w-full bg-emerald-600 text-white font-black py-4 rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-900/20">
                            <span>💬</span> Chat on WhatsApp
                        </a>
                    </div>

                    <!-- Call/SMS Section -->
                    <div class="pt-4 border-t border-stone-100">
                        <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-3">Call or SMS</p>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="tel:+254711317235" class="bg-stone-100 p-4 rounded-xl text-center font-bold text-teal-900 hover:bg-stone-200 transition">
                                0711 317 235
                            </a>
                            <a href="tel:+254104174064" class="bg-stone-100 p-4 rounded-xl text-center font-bold text-teal-900 hover:bg-stone-200 transition">
                                0104 174 064
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="pt-4 border-t border-stone-100">
                        <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest mb-2">Email</p>
                        <a href="mailto:dancanokeyo08@gmail.com" class="text-teal-900 font-bold underline hover:text-teal-700">
                            dancanokeyo08@gmail.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Support Context Box -->
            <div class="bg-teal-900 p-8 md:p-10 rounded-3xl shadow-xl flex flex-col justify-center text-white">
                <h3 class="text-xl font-black mb-4">Direct Support</h3>
                <p class="text-teal-100 mb-8 leading-relaxed">
                    If you are inquiring about a specific welfare association, please include the association name and your member ID for faster processing.
                </p>
                <div class="bg-teal-800 p-6 rounded-2xl">
                    <p class="text-teal-300 text-xs font-black uppercase mb-2">Office Hours</p>
                    <p class="font-bold">Mon - Fri: 8:00 AM - 5:00 PM</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection