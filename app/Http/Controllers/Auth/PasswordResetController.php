<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    public function showForgot() 
    { 
        return view('auth.forgot-password'); 
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $user = User::where('email', $request->email)->first();
        $otp = rand(1000, 9999);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);
        
        Mail::raw("Your password reset code is $otp.", function($m) use ($user) {
            $m->to($user->email)->subject('Password Reset OTP');
        });

        // Log the user in temporarily or manage a session to verify ownership
        Auth::login($user);
        
        return redirect()->route('verification.notice');
    }

    public function showReset() 
    { 
        // Only allow if user is authenticated and verified
        if (!auth()->check()) return redirect('/login');
        
        return view('auth.reset-password'); 
    }

    public function update(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:8']);
        
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);
        
        Auth::logout();
        return redirect('/login')->with('status', 'Password reset successfully! Please log in.');
    }
}