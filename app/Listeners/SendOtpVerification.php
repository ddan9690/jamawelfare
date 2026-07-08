<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationEmail; // Make sure this import is here

class SendOtpVerification
{
    public function handle(Registered $event)
    {
        $user = $event->user;
        $otp = rand(1000, 9999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(30)
        ]);

        // This sends the formatted Mailable instead of raw text
        Mail::to($user->email)->send(new OtpVerificationEmail($user, $otp));
    }
}