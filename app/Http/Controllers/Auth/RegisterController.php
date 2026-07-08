<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register', ['counties' => County::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tsc_number' => ['required', 'string', 'max:20', 'unique:users'], // Added validation
            'county_id' => ['required', 'exists:counties,id'],
            'level' => ['required', 'in:Primary,Junior School,Senior School,Tertiary'],
            'phone' => ['required', 'digits:9'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tsc_number' => $request->tsc_number, // Added to create
            'county_id' => $request->county_id,
            'level' => $request->level,
            'phone' => '254' . $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}