<footer class="bg-teal-900 text-stone-300 py-12 px-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h4 class="text-white font-bold text-lg mb-1">JamaWelfare</h4>
            {{-- <p class="text-sm">Modernizing welfare management for the Kenyan educator.</p> --}}
        </div>
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a>
            <a href="{{ route('terms') }}" class="hover:text-white transition">Terms & Conditions</a>
        </div>
    </div>
    <div class="max-w-6xl mx-auto text-center mt-8 pt-6 border-t border-teal-800 text-sm">
        &copy; {{ date('Y') }} JamaWelfare. All rights reserved.
    </div>
</footer>