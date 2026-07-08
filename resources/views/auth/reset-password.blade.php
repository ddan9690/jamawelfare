<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | JamaWelfare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-stone-50 text-stone-900 font-sans min-h-screen flex flex-col items-center justify-center p-6">

    <div class="mb-10 text-center">
        <a href="/" class="text-3xl font-black text-teal-900">
            Jama<span class="text-amber-600">Welfare</span>
        </a>
    </div>

    <div x-data="{ showPass: false, password: '', password_confirmation: '' }" 
         class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200">
        
        <h2 class="text-2xl font-bold text-teal-900 mb-2">Set New Password</h2>
        <p class="text-stone-600 mb-8 text-sm">Please enter your new password to secure your account.</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-xs font-bold">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/reset-password" method="POST" class="space-y-4">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="relative">
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">New Password</label>
                <input :type="showPass ? 'text' : 'password'" 
                       x-model="password" 
                       name="password" 
                       class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none" 
                       required>
                <button type="button" @click="showPass = !showPass" class="absolute right-4 top-9 text-stone-400">
                    <i class='bx' :class="showPass ? 'bx-hide' : 'bx-show'"></i>
                </button>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Confirm New Password</label>
                <input type="password" 
                       x-model="password_confirmation" 
                       name="password_confirmation" 
                       class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none" 
                       required>
                <p x-show="password_confirmation.length > 0 && password !== password_confirmation" 
                   class="text-red-500 text-[10px] mt-1 font-bold uppercase tracking-wide">
                    Passwords do not match
                </p>
            </div>

            <button type="submit" class="w-full bg-teal-900 text-white py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-teal-900/20 mt-6">
                Reset Password
            </button>
        </form>
    </div>

    <p class="mt-8 text-stone-400 text-xs">&copy; {{ date('Y') }} JamaWelfare. All rights reserved.</p>

</body>
</html>