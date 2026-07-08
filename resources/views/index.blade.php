@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<header class="bg-white py-20 px-6 text-center border-b border-stone-100">
    <div class="max-w-4xl mx-auto">
        <p class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-4">Empowering the Kenyan Educator</p>
        <h1 class="text-4xl md:text-6xl font-black text-teal-900 mb-8 leading-tight">
            Stronger Together, <br><span class="text-teal-700">Managed with Precision.</span>
        </h1>
        
        <!-- Image placed immediately after hero text -->
        <div class="my-12">
            <img src="{{ asset('images/teachers-holding-hands.png') }}" class="w-full max-h-[400px] object-cover rounded-[3rem] shadow-2xl" alt="Community support">
        </div>

        <div class="text-lg text-stone-600 mb-12 space-y-6 max-w-2xl mx-auto">
            <p>For generations, Kenyan teacher welfare associations have served as the vital heartbeat of our educational community. However, as our needs evolve, many of these groups struggle under the weight of manual, paper-based records, resulting in administrative burnout.</p>
            <p class="text-stone-800 font-black text-xl">JamaWelfare bridges this gap. We provide the digital infrastructure that transforms welfare management.</p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="/explore" class="bg-amber-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-teal-900 transition shadow-lg">Explore Welfares</a>
            <a href="/contact" class="bg-teal-900 text-white px-8 py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg">Onboard My Welfare</a>
        </div>
    </div>
</header>

<!-- Digital Benefits Section -->
<section class="py-20 px-6 bg-stone-50">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-4xl font-black text-teal-900 mb-6">Your Welfare, <br><span class="text-amber-600">In Your Pocket.</span></h2>
            <p class="text-stone-600 mb-8 text-lg leading-relaxed">Don't walk the path alone. Join a community that understands the unique challenges of the profession. With JamaWelfare, you gain instant visibility into your contribution ledgers, track benefits in real-time, and enjoy the peace of mind that comes with a transparent, tech-enabled welfare group.</p>
            <a href="/explore" class="inline-block bg-teal-900 text-white px-8 py-4 rounded-xl font-bold hover:bg-teal-700">Find your community &rarr;</a>
        </div>
        <div>
            <img src="{{ asset('images/teacher-holding-phone.png') }}" class="w-full rounded-[3rem] shadow-2xl rotate-1 hover:rotate-0 transition duration-500" alt="Member using JamaWelfare">
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 px-6 max-w-5xl mx-auto text-center">
    <h2 class="text-3xl font-bold text-teal-900 mb-12">Why JamaWelfare?</h2>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6 bg-white rounded-2xl border border-stone-100 shadow-sm">
            <i class='bx bx-shield-check text-4xl text-amber-600 mb-4'></i>
            <h3 class="font-bold text-lg">Unrivaled Transparency</h3>
            <p class="text-sm text-stone-600 mt-2">Every contribution is recorded. Trust is earned through data you can see.</p>
        </div>
        <div class="p-6 bg-white rounded-2xl border border-stone-100 shadow-sm">
            <i class='bx bx-tachometer text-4xl text-amber-600 mb-4'></i>
            <h3 class="font-bold text-lg">Seamless Efficiency</h3>
            <p class="text-sm text-stone-600 mt-2">Automate the tedious tasks that keep you from real member engagement.</p>
        </div>
        <div class="p-6 bg-white rounded-2xl border border-stone-100 shadow-sm">
            <i class='bx bx-message-rounded-dots text-4xl text-amber-600 mb-4'></i>
            <h3 class="font-bold text-lg">Community First</h3>
            <p class="text-sm text-stone-600 mt-2">Built by those who understand the culture of Kenyan educators.</p>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-20 px-6 bg-teal-900 text-white text-center">
    <h2 class="text-3xl font-bold mb-6">Ready to lead the change?</h2>
    <p class="text-teal-100 mb-10 max-w-lg mx-auto">Join a network of teachers choosing efficiency and community. Your journey starts here.</p>
    <a href="/explore" class="bg-amber-600 px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-teal-900 transition">Explore Welfares Now</a>
</section>
@endsection