<?php

namespace App\Http\Controllers;

use App\Models\{WelfareBenevolenceCase, WelfareContribution, WelfareMember};
use Illuminate\Support\Facades\{Session, Auth};

class MemberProfileController extends Controller
{
    public function myCases()
    {
        $welfareId = Session::get('active_welfare_id');
        $member = WelfareMember::where('welfare_id', $welfareId)->where('user_id', Auth::id())->first();

        $cases = $member
            ? WelfareBenevolenceCase::where('member_id', $member->id)->with('category')->get()
            : collect();

        return view('dashboard.member.my-cases', compact('cases'));
    }

    public function myContributions()
    {
        $welfareId = Session::get('active_welfare_id');
        $member = WelfareMember::where('welfare_id', $welfareId)->where('user_id', Auth::id())->first();

        // Get paginated cases sorted by newest (latest) first
        $allCases = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->with(['member.user', 'category'])
            ->latest()
            ->paginate(50);

        // Get user's contributions indexed by case ID for quick lookup
        $myContributions = $member
            ? WelfareContribution::where('member_id', $member->id)->get()->keyBy('welfare_benevolence_case_id')
            : collect();

        return view('dashboard.member.my-contributions', compact('allCases', 'myContributions'));
    }
}
