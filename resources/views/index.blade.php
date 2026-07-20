@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<header class="bg-white py-20 px-6 border-b border-stone-100 overflow-hidden">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div class="text-left" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <span class="inline-block bg-teal-50 text-teal-800 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase mb-6">Introducing JamaWelfare</span>
            
            <h1 class="text-4xl md:text-5xl font-black text-teal-900 mb-6 leading-tight transition-all duration-700 transform"
                :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                Your trusted digital partner for modern teacher welfares.
            </h1>
            
            <p class="text-stone-600 text-lg mb-8 leading-relaxed transition-all duration-700 delay-100 transform"
               :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                Managing contributions, keeping records clear, and supporting members shouldn't mean endless manual logs and administrative headaches. JamaWelfare brings your teacher associations into one clean, structured digital home.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 transition-all duration-700 delay-200 transform"
                 :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                <a href="/explore" class="bg-teal-900 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-teal-800 transition text-center shadow-sm">Explore Active Welfares</a>
                <a href="/contact" class="bg-stone-100 text-teal-900 border border-stone-200 px-8 py-3.5 rounded-xl font-bold hover:bg-stone-200 transition text-center">Onboard Your Group</a>
            </div>
        </div>
        
        <div x-data="{ showImg: false }" x-init="setTimeout(() => showImg = true, 250)"
             class="transition-all duration-1000 transform"
             :class="showImg ? 'translate-x-0 opacity-100' : 'translate-x-6 opacity-0'">
            <img src="{{ asset('images/teachers-holding-hands.png') }}" class="w-full max-h-[450px] object-cover rounded-[2.5rem] shadow-xl border border-stone-100" alt="Kenyan educators collaborating">
        </div>
    </div>
</header>

<!-- Story Section: The Heart & Challenges of Welfare Associations -->
<section class="py-20 px-6 bg-stone-50 border-b border-stone-100">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-3 block">Our Shared Journey</span>
        <h2 class="text-3xl md:text-4xl font-black text-teal-900 mb-6">More than groups. We build families.</h2>
        <div class="text-stone-600 text-lg leading-relaxed space-y-6 text-left md:text-center max-w-3xl mx-auto mb-16">
            <p>
                Welfare associations have long been a core part of our lives as Kenyan educators. They are the avenues where we come together to support one another through life's milestones and emergencies because no man is an island. Over time, these groups have grown into true families.
            </p>
            <p>
                However, despite being deeply woven into our daily routine, welfare associations have faced growing challenges that threaten their core purpose.
            </p>
        </div>

        <!-- Creative Challenges Grid with Alpine Transition -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-left" 
             x-data="{ activeCard: null }">
            
            <div @mouseenter="activeCard = 1" @mouseleave="activeCard = null"
                 :class="activeCard === 1 ? '-translate-y-1 shadow-md border-teal-200' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-red-50 text-red-700 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-trending-down'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Low Participation</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Members drifting away from meetings and active involvement in group welfare events.</p>
            </div>

            <div @mouseenter="activeCard = 2" @mouseleave="activeCard = null"
                 :class="activeCard === 2 ? '-translate-y-1 shadow-md border-amber-200' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-amber-50 text-amber-700 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-wallet'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Low Contributions</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Delays and shortfalls in meeting financial obligations when emergencies strike.</p>
            </div>

            <div @mouseenter="activeCard = 3" @mouseleave="activeCard = null"
                 :class="activeCard === 3 ? '-translate-y-1 shadow-md border-orange-200' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-orange-50 text-orange-700 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-hide'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Transparency Gaps</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Unclear ledger books and doubts about how funds are tracked and utilized.</p>
            </div>

            <div @mouseenter="activeCard = 4" @mouseleave="activeCard = null"
                 :class="activeCard === 4 ? '-translate-y-1 shadow-md border-stone-300' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-stone-100 text-stone-700 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-battery'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Administrative Fatigue</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Exhaustion setting in for both leaders and members trying to keep records straight.</p>
            </div>

            <div @mouseenter="activeCard = 5" @mouseleave="activeCard = null"
                 :class="activeCard === 5 ? '-translate-y-1 shadow-md border-yellow-200' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-yellow-50 text-yellow-700 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-copy'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Multiple Memberships Duplicity</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Overlapping entries and confusion as members juggle commitments across various overlapping groups.</p>
            </div>

            <div @mouseenter="activeCard = 6" @mouseleave="activeCard = null"
                 :class="activeCard === 6 ? '-translate-y-1 shadow-md border-teal-200' : 'shadow-sm'"
                 class="bg-white p-6 rounded-2xl border border-stone-200 transition-all duration-300">
                <div class="w-10 h-10 bg-teal-50 text-teal-900 rounded-xl flex items-center justify-center font-bold text-lg mb-4">
                    <i class='bx bx-bot'></i>
                </div>
                <h3 class="font-bold text-stone-900 mb-1">Overwhelmed Officials</h3>
                <p class="text-stone-600 text-xs leading-relaxed">Welfare officials buried under manual record keeping, effectively turned into automated robots.</p>
            </div>
        </div>
    </div>
</section>

<!-- The Solution: Enter JamaWelfare -->
<section class="py-20 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-teal-700 font-bold tracking-widest uppercase text-xs mb-2 block">The Modern Approach</span>
            <h2 class="text-3xl font-black text-teal-900 mb-4">Enter JamaWelfare</h2>
            <p class="text-stone-600">Making welfares more meaningful, cutting down manual workloads, and giving everyone clear visibility into what's happening.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h3 class="text-2xl font-black text-teal-900 mb-4">For Members: Total Clarity & Control</h3>
                <p class="text-stone-600 leading-relaxed mb-6">
                    Every member gets a personal dashboard to track live contribution history, view ongoing benevolence cases, and stay informed without relying on rumors or delayed announcements.
                </p>
                <ul class="space-y-3 text-stone-700 font-medium text-sm">
                    <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Real-time tracking of personal contribution ledgers</li>
                    <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Direct updates on benevolence and emergency cases</li>
                    <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Complete transparency on association movements</li>
                </ul>
            </div>
            <div class="bg-stone-50 p-8 rounded-3xl border border-stone-200 shadow-sm">
                <h3 class="text-2xl font-black text-teal-900 mb-4">For Officials: Goodbye Guesswork</h3>
                <p class="text-stone-600 leading-relaxed mb-6">
                    Welfare officials get a clear, precise picture of how members are participating without relying on guesswork or scrambling through random notebook discoveries.
                </p>
                <div class="bg-white p-5 rounded-2xl border border-stone-200">
                    <p class="text-xs text-stone-500 italic mb-2">"Better a few committed members than thousands with nothing going on."</p>
                    <p class="text-xs font-bold text-teal-900">Our system automatically flags inactive profiles, helping your association focus entirely on willing and dedicated participants.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Secondary Context Section -->
<section class="py-20 px-6 bg-stone-50 border-t border-stone-100">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div>
            <img src="{{ asset('images/teacher-holding-phone.png') }}" class="w-full rounded-[2.5rem] shadow-xl border border-stone-100 object-cover max-h-[400px]" alt="Teacher managing account">
        </div>
        <div>
            <span class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-2 block">Always Accessible</span>
            <h2 class="text-3xl font-black text-teal-900 mb-6">Your welfare details, right in your hands.</h2>
            <p class="text-stone-600 mb-6 leading-relaxed">
                Whether you are checking the status of an active claim or verifying recent group statements, JamaWelfare gives you direct access on any device without needing to call leadership for updates.
            </p>
            <ul class="space-y-3 text-stone-700 font-medium text-sm mb-8">
                <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Instant visibility into membership status</li>
                <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Structured updates for group activities</li>
                <li class="flex items-center gap-3"><i class='bx bx-check text-teal-700 text-lg'></i> Secure records managed by group leaders</li>
            </ul>
            <a href="/explore" class="inline-flex items-center gap-2 bg-teal-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-teal-800 transition">
                Browse Welfares <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section class="py-20 px-6 bg-teal-900 text-white text-center">
    <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 items-center bg-teal-950/40 p-8 md:p-12 rounded-3xl border border-teal-800">
        <div class="text-left">
            <span class="text-amber-500 font-bold uppercase text-xs tracking-wider mb-2 block">For Visitors</span>
            <h3 class="text-2xl font-black mb-3">Looking for a community to join?</h3>
            <p class="text-teal-100 text-sm mb-6">Explore active teacher welfare associations across different counties and find a group that fits your needs.</p>
            <a href="/explore" class="inline-block bg-amber-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-amber-500 transition shadow-sm">Explore Welfares Now</a>
        </div>

        <div class="text-left border-t md:border-t-0 md:border-l border-teal-800 pt-6 md:pt-0 md:pl-8">
            <span class="text-amber-500 font-bold uppercase text-xs tracking-wider mb-2 block">For Welfare Admins</span>
            <h3 class="text-2xl font-black mb-3">Want to streamline your group?</h3>
            <p class="text-teal-100 text-sm mb-6">Onboard your welfare association to JamaWelfare today and enjoy automated records, clarity, and engaged members.</p>
            <a href="/contact" class="inline-block bg-white text-teal-900 px-6 py-3 rounded-xl font-bold text-sm hover:bg-stone-100 transition shadow-sm">Onboard My Welfare</a>
        </div>
    </div>
</section>
@endsection