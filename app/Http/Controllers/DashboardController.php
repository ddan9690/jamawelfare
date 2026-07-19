<?php

namespace App\Http\Controllers;

use App\Models\Welfare; // Added
use App\Models\WelfareBenevolenceCase;
use App\Models\WelfareContribution;
use App\Models\WelfareMember;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $welfareId = session('active_welfare_id');
        $userId = auth()->id();

        $activeWelfare = \App\Models\Welfare::find($welfareId);

        $members = \App\Models\WelfareMember::where('welfare_id', $welfareId)
            ->with('user:id,level,gender')
            ->get();

        $stats = [
            'levels' => $members->groupBy('user.level')->map->count(),
            'genders' => $members->groupBy('user.gender')->map->count(),
        ];

        $member = \App\Models\WelfareMember::where('welfare_id', $welfareId)
            ->where('user_id', $userId)
            ->first();

        $solidarityBalance = $member ? $member->solidarity_balance : 0;
        $solidarityTransactions = $member ? $member->solidarityFunds()->latest()->get() : collect();

        $myContributions = $member ? \App\Models\WelfareContribution::with(['case.member.user'])
            ->where('member_id', $member->id)
            ->latest('payment_date')
            ->get() : collect();

        $activeCases = $activeWelfare ? $activeWelfare->benevolenceCases()
            ->where('status', 'active')
            ->with('member.user')
            ->latest()
            ->paginate(6) : collect();

        $activeMemberRole = $member ? $member->role : null;

        return view('dashboard.index', compact(
            'myContributions',
            'activeCases',
            'stats',
            'member',
            'solidarityBalance',
            'solidarityTransactions',
            'activeWelfare',
            'activeMemberRole'
        ));
    }

    public function searchMembers(Request $request)
{
    $query = $request->get('q');
    $welfareId = session('active_welfare_id');

    if (empty($query)) return response()->json([]);

    try {
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('tsc_number', 'like', "%{$query}%");
            })
            ->orWhere('member_number', 'like', "%{$query}%")
            ->with('user:id,name,tsc_number,phone') // Ensure these columns exist
            ->limit(5)
            ->get();

        return response()->json($members);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
