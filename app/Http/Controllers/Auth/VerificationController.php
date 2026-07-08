<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function show() 
    { 
        return view('auth.verify-otp'); 
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);
        
        $user = auth()->user();

        // Check if code matches and is not expired
        if ($user && $request->otp == $user->otp && now()->lt($user->otp_expires_at)) {
            $user->markEmailAsVerified();
            return redirect('/dashboard');
        }

        return back()->withErrors(['otp' => 'The code is invalid or has expired.']);
    }

    public function resend(Request $request)
    {
        $user = auth()->user();
        $otp = rand(1000, 9999);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(30)
        ]);
        
        Mail::raw("Your new verification code is $otp.", function($m) use ($user) {
            $m->to($user->email)->subject('Resent OTP');
        });

        return back()->with('status', 'A new code has been sent to your email.');
    }
}