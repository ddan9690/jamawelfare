<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JamaWelfare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-stone-50 text-stone-900 font-sans min-h-screen flex flex-col items-center justify-center p-6">

    <!-- Branding -->
    <div class="mb-10 text-center">
        <a href="/" class="text-3xl font-black text-teal-900">
            Jama<span class="text-amber-600">Welfare</span>
        </a>
    </div>

    <!-- Login Card -->
    <div x-data="{ showPass: false }"
        class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200">

        <!-- Global Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                <ul class="text-xs font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none transition"
                    required>
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-bold text-stone-700 uppercase">Password</label>
                    <a href="/forgot-password" class="text-xs text-amber-600 font-bold hover:underline">Forgot?</a>
                </div>
                <div class="relative">
                    <input :type="showPass ? 'text' : 'password'" name="password"
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none transition"
                        required>
                    <button type="button" @click="showPass = !showPass" class="absolute right-4 top-3 text-stone-400">
                        <i class='bx' :class="showPass ? 'bx-hide' : 'bx-show'"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-teal-900 text-white py-4 rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-teal-900/20 mt-6">
                Sign In
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-stone-600">
            Don't have an account? <a href="/register" class="text-amber-600 font-bold hover:underline">Register
                here</a>
        </p>
    </div>

    <!-- Footer -->
    <p class="mt-8 text-stone-400 text-xs">&copy; {{ date('Y') }} JamaWelfare. All rights reserved.</p>

</body>

</html>
