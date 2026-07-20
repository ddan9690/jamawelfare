@extends('layouts.frontend')

@section('title', 'Terms and Conditions')

@section('content')
<!-- Hero Section -->
<header class="bg-white py-16 px-6 border-b border-stone-100">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-teal-50 text-teal-800 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase mb-4">Legal & Compliance</span>
        <h1 class="text-3xl md:text-4xl font-black text-teal-900 mb-4">Terms and Conditions</h1>
        <p class="text-stone-500 text-sm">Last updated: July 20, 2026</p>
    </div>
</header>

<!-- Content Section -->
<section class="py-16 px-6 bg-stone-50">
    <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-3xl border border-stone-200 shadow-sm space-y-8 text-stone-700 text-sm leading-relaxed">
        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">1. Acceptance of Terms</h2>
            <p>By accessing or using JamaWelfare, you agree to comply with and be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our platform.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">2. User Accounts and Responsibilities</h2>
            <p class="mb-2">Users are responsible for maintaining the confidentiality of their account credentials. Welfare administrators and members must ensure that all contribution records and personal updates entered into the system are accurate and lawful.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">3. Welfare Association Management</h2>
            <p>JamaWelfare provides digital infrastructure for organized groups. While our system automates record tracking and transparency features, individual welfare groups retain full autonomy over their internal bylaws, contribution rates, and disbursement policies.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">4. Prohibited Conduct</h2>
            <p>Users agree not to misuse the platform, attempt unauthorized access to other association data, or upload malicious code, fraudulent records, or unlawful material.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">5. Modifications to Terms</h2>
            <p>We reserve the right to modify these terms at any time. Continued use of JamaWelfare following any updates constitutes your formal acceptance of the revised terms.</p>
        </div>
    </div>
</section>
@endsection