<x-mail::message>
# Hello, {{ $user->name }}!

Welcome to **JamaWelfare**. We are glad to have you with us.

To complete your registration, please use the One-Time Password (OTP) below:

<div style="text-align: center; margin: 20px 0;">
    <span style="font-size: 32px; font-weight: bold; color: #0f766e; letter-spacing: 5px;">{{ $otp }}</span>
</div>

**This code expires in 30 minutes.**

If you did not create an account with JamaWelfare, please ignore this email. No further action is required.

Thanks,<br>
The JamaWelfare Team
</x-mail::message>