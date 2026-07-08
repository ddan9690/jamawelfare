<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent | JamaWelfare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900 font-sans min-h-screen flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-sm border border-stone-200 text-center">
        <div class="text-5xl text-amber-600 mb-6"><i class='bx bx-envelope'></i></div>
        <h2 class="text-2xl font-bold text-teal-900 mb-2">Check your inbox</h2>
        <p class="text-stone-600 mb-6">We've sent a password reset link to your email address.</p>
        <a href="/login" class="text-teal-900 font-bold hover:underline">Back to Login</a>
    </div>
</body>
</html>