<?php

namespace App\Http\Controllers;

use App\Models\{WelfareMember};
use App\Models\WelfareBenevolenceCase;
use App\Models\WelfareContribution;
use Illuminate\Support\Facades\{Auth, Session};

class DashboardController extends Controller
{
   public function index()
{
    $welfareId = Session::get('active_welfare_id');
    $userId = Auth::id();

    // 1. Existing Member/Contribution Logic
    $member = WelfareMember::where('welfare_id', $welfareId)->where('user_id', $userId)->first();
    $myContributions = collect();
    
    // 2. Fetch Welfare Members with their User profile
    $members = WelfareMember::where('welfare_id', $welfareId)
        ->with('user')
        ->get();

    // Calculate Statistics
    $stats = [
        'levels' => $members->groupBy('user.level')->map->count(),
        'genders' => $members->groupBy('user.gender')->map->count(),
    ];

    if ($member) {
        $myContributions = WelfareContribution::with(['case.member.user'])
            ->where('member_id', $member->id)
            ->latest('payment_date')
            ->get();
    }

    $activeCases = WelfareBenevolenceCase::where('welfare_id', $welfareId)
        ->where('status', 'active')
        ->with('member.user')
        ->latest()
        ->paginate(6);

    return view('dashboard.index', compact('myContributions', 'activeCases', 'stats'));
}
}
