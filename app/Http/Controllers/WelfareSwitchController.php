<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WelfareMember;
use Illuminate\Support\Facades\Session;

class WelfareSwitchController extends Controller
{
    public function switch(Request $request, $welfareId)
    {
        $isMember = WelfareMember::where('user_id', auth()->id())
                                 ->where('welfare_id', $welfareId)
                                 ->exists();

        $isSuperAdmin = auth()->user()->is_super_admin;

        if ($isMember || $isSuperAdmin) {
            Session::put('active_welfare_id', $welfareId);
        } else {
            session()->flash('error', 'You are not a member of this welfare.');
        }

        return redirect()->intended('/dashboard');
    }
}