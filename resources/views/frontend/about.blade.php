@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
<section class="py-12 md:py-20 px-4 md:px-6 bg-stone-50">
    <div class="max-w-4xl mx-auto">
        
        <!-- Mission Header -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-teal-900 mb-6">Empowering Communities Through Transparency</h1>
            <p class="text-stone-600 text-lg leading-relaxed max-w-2xl mx-auto">
                We believe that professional associations and welfare groups are the backbone of Kenyan society. Our platform is dedicated to digitizing these connections, making benevolence and contribution management seamless for everyone.
            </p>
        </div>

        <!-- Vision/Values Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-20">
            <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                <div class="text-3xl mb-4">🎯</div>
                <h3 class="font-black text-teal-900 mb-2">Our Mission</h3>
                <p class="text-sm text-stone-600 leading-relaxed">To provide intuitive, automated tools that simplify financial administration for professional associations across Kenya.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                <div class="text-3xl mb-4">🛡️</div>
                <h3 class="font-black text-teal-900 mb-2">Transparency</h3>
                <p class="text-sm text-stone-600 leading-relaxed">Building trust by ensuring every member has real-time access to their contribution ledgers and case participation history.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                <div class="text-3xl mb-4">🚀</div>
                <h3 class="font-black text-teal-900 mb-2">Efficiency</h3>
                <p class="text-sm text-stone-600 leading-relaxed">Moving from manual paper-based records to digital, high-speed analysis and automated reporting.</p>
            </div>
        </div>

        <!-- Story Section -->
        <div class="bg-white p-8 md:p-12 rounded-3xl border border-stone-100 shadow-sm flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1">
                <h2 class="text-2xl font-black text-teal-900 mb-4">Built for Professionals</h2>
                <p class="text-stone-600 leading-relaxed mb-6">
                    Our journey started with a simple observation: managing welfare contributions and benevolence cases in large organizations was complex, prone to error, and lacked transparency.
                </p>
                <p class="text-stone-600 leading-relaxed">
                    Designed by developers and teachers who understand the nuances of the Kenyan professional landscape, this platform ensures that you spend less time on administration and more time supporting your colleagues when it matters most.
                </p>
            </div>
            <div class="w-full md:w-1/3 aspect-square bg-teal-900 rounded-3xl flex items-center justify-center text-6xl">
                🇰🇪
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <h3 class="text-xl font-black text-teal-900 mb-6">Ready to get started?</h3>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('frontend.explore') }}" class="bg-teal-900 text-white px-8 py-4 rounded-xl font-black hover:bg-amber-600 transition shadow-lg">Explore Welfares</a>
                <a href="/contact" class="bg-white text-teal-900 px-8 py-4 rounded-xl font-black border border-stone-200 hover:bg-stone-50 transition">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection