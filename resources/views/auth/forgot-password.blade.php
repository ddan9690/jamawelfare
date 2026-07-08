<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | JamaWelfare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-stone-50 text-stone-900 font-sans min-h-screen flex flex-col items-center justify-center p-6">

    <div class="mb-10 text-center">
        <a href="/" class="text-2xl font-black text-teal-900">
            Jama<span class="text-amber-600">Welfare</span>
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200 text-center">
        
        <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
            <i class='bx bx-mobile-alt'></i>
        </div>

        <h2 class="text-2xl font-bold text-teal-900 mb-2">Password Recovery</h2>
        <p class="text-stone-600 text-sm mb-8">
            Enter your email address. We will send a 4-digit OTP code to verify it's you.
        </p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/forgot-password" method="POST" class="space-y-4">
            @csrf
            
            <div class="text-left">
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Email Address</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="name@example.com"
                       class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none" 
                       required>
            </div>

            <button type="submit" class="w-full bg-teal-900 text-white py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-teal-900/20 mt-2">
                Send OTP Code
            </button>
        </form>
    </div>
</body>
</html>