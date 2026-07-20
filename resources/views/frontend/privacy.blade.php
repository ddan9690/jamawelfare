@extends('layouts.frontend')

@section('title', 'Privacy Policy')

@section('content')
<!-- Hero Section -->
<header class="bg-white py-16 px-6 border-b border-stone-100">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-teal-50 text-teal-800 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase mb-4">Legal & Compliance</span>
        <h1 class="text-3xl md:text-4xl font-black text-teal-900 mb-4">Privacy Policy</h1>
        <p class="text-stone-500 text-sm">Last updated: July 20, 2026</p>
    </div>
</header>

<!-- Content Section -->
<section class="py-16 px-6 bg-stone-50">
    <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-3xl border border-stone-200 shadow-sm space-y-8 text-stone-700 text-sm leading-relaxed">
        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">1. Introduction</h2>
            <p>Welcome to JamaWelfare. We respect your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, and safeguard your information when you visit our platform or utilize our digital welfare management services.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">2. Information We Collect</h2>
            <p class="mb-2">To provide efficient welfare association management, we may collect the following types of information:</p>
            <ul class="list-disc list-inside space-y-1 text-stone-600">
                <li>Personal identification details (Name, email address, phone number).</li>
                <li>Association membership data, roles, and contribution records.</li>
                <li>System usage logs and technical device information.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">3. How We Use Your Information</h2>
            <p>Your information is used strictly to operate and improve JamaWelfare features, maintain secure contribution ledgers, facilitate communication between group leaders and members, and ensure platform security.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">4. Data Security</h2>
            <p>We implement robust technical and administrative security measures to protect your data from unauthorized access, alteration, or disclosure. Only authorized welfare officials and members have access to respective group ledgers.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-teal-900 mb-3">5. Contact Us</h2>
            <p>If you have any questions or concerns regarding this privacy policy, please reach out to us through our contact page.</p>
        </div>
    </div>
</section>
@endsection