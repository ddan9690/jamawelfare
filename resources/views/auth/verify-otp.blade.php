<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | JamaWelfare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-stone-50 text-stone-900 font-sans min-h-screen flex flex-col items-center justify-center p-6">

    <div class="mb-10 text-center">
        <a href="/" class="text-3xl font-black text-teal-900">
            Jama<span class="text-amber-600">Welfare</span>
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200 text-center">
        
        <div class="w-16 h-16 bg-teal-50 text-teal-900 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
            <i class='bx bx-envelope'></i>
        </div>

        <h2 class="text-2xl font-bold text-teal-900 mb-4">Verify your identity</h2>
        <p class="text-stone-600 text-sm mb-8 leading-relaxed">
            Dear {{ auth()->user()->name ?? 'Member' }}, a one-time password (OTP) has been sent to your email 
            <span class="font-bold text-teal-900">{{ auth()->user()->email ?? 'your email' }}</span>. 
            Check your email and enter the 4-digit OTP here.
        </p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/verify-otp" method="POST" class="space-y-6">
            @csrf
            
            <input type="text" 
                   name="otp" 
                   maxlength="4" 
                   pattern="\d{4}" 
                   placeholder="0000" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   class="w-full text-center text-4xl tracking-[1rem] py-4 rounded-xl border-2 border-stone-200 focus:border-amber-500 focus:ring-0 outline-none font-black text-teal-900" 
                   required>

            <button type="submit" class="w-full bg-teal-900 text-white py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-teal-900/20">
                Verify OTP
            </button>
        </form>

        <form action="/resend-otp" method="POST" class="mt-6">
            @csrf
            <p class="text-xs text-stone-500">
                Didn't get the code? 
                <button type="submit" class="text-amber-600 font-bold hover:underline">Resend OTP</button>
            </p>
        </form>
    </div>

</body>
</html>