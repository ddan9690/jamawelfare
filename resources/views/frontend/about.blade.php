@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<header class="bg-white py-20 px-6 border-b border-stone-100 overflow-hidden" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-teal-50 text-teal-800 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase mb-6 transition-all duration-700 transform"
              :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
            About JamaWelfare
        </span>
        
        <h1 class="text-4xl md:text-5xl font-black text-teal-900 mb-6 leading-tight transition-all duration-700 delay-100 transform"
            :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
            Rooted in community. Powered by modern infrastructure.
        </h1>
        
        <p class="text-stone-600 text-lg mb-8 leading-relaxed max-w-2xl mx-auto transition-all duration-700 delay-200 transform"
           :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
            JamaWelfare was born out of a deep understanding of Kenyan teacher associations—valuable spaces where educators pool resources, support families, and stand shoulder to shoulder through every season of life.
        </p>
    </div>
</header>

<!-- Our Mission & Story -->
<section class="py-20 px-6 bg-stone-50 border-b border-stone-100">
    <div class="max-w-5xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-2 block">Our Purpose</span>
            <h2 class="text-3xl font-black text-teal-900 mb-4">Restoring dignity and clarity to group leadership</h2>
            <p class="text-stone-600 text-sm">Empowering educators with structured digital infrastructure to replace administrative burnout.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h3 class="text-2xl font-black text-teal-900 mb-6">Built to lift the weight of manual administration.</h3>
                <p class="text-stone-600 mb-4 leading-relaxed">
                    For years, welfare groups have relied heavily on physical logbooks, fragmented mobile money statements, and manual spreadsheets. While the intent and spirit of togetherness have always been strong, the administrative burden often burns out officials and leaves members in the dark.
                </p>
                <p class="text-stone-600 leading-relaxed">
                    We built JamaWelfare to lift that weight. By introducing automated tracking, real-time ledgers, and clear member directories, we give groups the structure they need to thrive without losing their personal touch.
                </p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-stone-200 shadow-sm space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-teal-50 text-teal-900 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
                        <i class='bx bx-check-shield'></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-teal-900 mb-1">Absolute Transparency</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Every contribution is logged and instantly visible to members, removing doubt and building unbreakable trust.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-amber-50 text-amber-700 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
                        <i class='bx bx-group'></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-teal-900 mb-1">Committed Communities</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Our automated tools highlight active participation, ensuring associations stay focused on dedicated members.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-stone-100 text-stone-700 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
                        <i class='bx bx-tachometer'></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-teal-900 mb-1">Effortless Operations</h4>
                        <p class="text-stone-600 text-xs leading-relaxed">Freeing welfare officials from manual record-keeping so they can focus on what truly matters: supporting each other.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 px-6 bg-white text-center">
    <div class="max-w-3xl mx-auto">
        <span class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-2 block">Get Started</span>
        <h2 class="text-3xl font-black text-teal-900 mb-4">Be part of the digital welfare movement.</h2>
        <p class="text-stone-600 mb-8 max-w-xl mx-auto">Whether you want to join an active association or migrate your group's records onto a clean platform, we are ready to walk with you.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/explore" class="bg-teal-900 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-teal-800 transition shadow-sm">Explore Active Welfares</a>
            <a href="/contact" class="bg-stone-100 text-teal-900 border border-stone-200 px-8 py-3.5 rounded-xl font-bold hover:bg-stone-200 transition">Get in Touch</a>
        </div>
    </div>
</section>
@endsection