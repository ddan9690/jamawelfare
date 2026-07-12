<?php

namespace App\Http\Controllers;

use App\Models\WelfareMember;
use App\Models\WelfareBenevolenceCase;
use App\Models\WelfareContribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
{
    $welfareId = Session::get('active_welfare_id');
    $userId = Auth::id();

    $member = WelfareMember::where('welfare_id', $welfareId)->where('user_id', $userId)->first();
    
    // Solidarity Fund Data
    $solidarityBalance = 0;
    $solidarityTransactions = collect();
    if ($member) {
        $solidarityBalance = $member->solidarity_balance;
        $solidarityTransactions = $member->solidarityFunds()->latest()->get();
    }

    $members = WelfareMember::where('welfare_id', $welfareId)->with('user')->get();
    $stats = [
        'levels' => $members->groupBy('user.level')->map->count(),
        'genders' => $members->groupBy('user.gender')->map->count(),
    ];

    $myContributions = $member ? WelfareContribution::with(['case.member.user'])
        ->where('member_id', $member->id)
        ->latest('payment_date')
        ->get() : collect();

    $activeCases = WelfareBenevolenceCase::where('welfare_id', $welfareId)
        ->where('status', 'active')
        ->with('member.user')
        ->latest()
        ->paginate(6);

    return view('dashboard.index', compact('myContributions', 'activeCases', 'stats', 'member', 'solidarityBalance', 'solidarityTransactions'));
}
}