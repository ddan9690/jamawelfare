<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | JamaWelfare</title>
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

    {{-- Added x-data for loading state management --}}
    <div x-data="{ showPass: false, password: '', password_confirmation: '', loading: false }"
        class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-stone-200">

        <h2 class="text-2xl font-bold text-teal-900 mb-2">Create an Account</h2>
        <p class="text-stone-600 mb-8 text-sm">Join the community of Kenyan educators today.</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                <ul class="text-xs font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST" class="space-y-4" @submit="loading = true">
            @csrf

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none"
                    required>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-2">Gender</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }} class="w-4 h-4 text-amber-600" required>
                        <span class="text-sm font-medium text-stone-700">Male</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }} class="w-4 h-4 text-amber-600" required>
                        <span class="text-sm font-medium text-stone-700">Female</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none"
                    required>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">TSC Number</label>
                <input type="text" name="tsc_number" value="{{ old('tsc_number') }}"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none"
                    required>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Phone Number</label>
                <div class="flex border border-stone-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-amber-500">
                    <input type="text" value="254" disabled class="w-16 px-3 bg-stone-100 text-stone-500 font-bold border-r border-stone-200 cursor-not-allowed">
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="711317235" maxlength="9" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full px-4 py-3 outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase mb-1">County</label>
                    <select name="county_id" class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white outline-none" required>
                        <option value="" disabled selected>Select...</option>
                        @foreach ($counties as $county)
                            <option value="{{ $county->id }}">{{ $county->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Level</label>
                    <select name="level" class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-white outline-none" required>
                        <option value="" disabled selected>Select...</option>
                        <option value="Primary">Primary</option>
                        <option value="Junior School">Junior School</option>
                        <option value="Senior School">Senior School</option>
                        <option value="Tertiary">Tertiary</option>
                    </select>
                </div>
            </div>

            <div class="relative">
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Password</label>
                <input :type="showPass ? 'text' : 'password'" x-model="password" name="password"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase mb-1">Confirm Password</label>
                <input type="password" x-model="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:ring-2 focus:ring-amber-500 outline-none" required>
            </div>

            <button type="submit"
                :disabled="loading"
                :class="loading ? 'bg-stone-400 cursor-not-allowed' : 'bg-teal-900 hover:bg-amber-600'"
                class="w-full text-white py-4 rounded-xl font-bold transition shadow-lg mt-6">
                <span x-show="!loading">Register Account</span>
                <span x-show="loading" class="flex items-center justify-center gap-2">
                    <i class='bx bx-loader-alt animate-spin'></i> Please wait...
                </span>
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-stone-600">
            Already have an account? <a href="/login" class="text-amber-600 font-bold hover:underline">Log in here</a>
        </p>
    </div>

    <p class="mt-8 text-stone-400 text-xs">&copy; {{ date('Y') }} JamaWelfare. All rights reserved.</p>

</body>
</html>