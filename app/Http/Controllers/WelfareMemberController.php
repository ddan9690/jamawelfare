<?php

namespace App\Http\Controllers;

use App\Models\Welfare;
use App\Models\WelfareBenevolenceCase;
use App\Models\WelfareMember;
use Illuminate\Http\Request;

class WelfareMemberController extends Controller
{
    /**
     * Display a listing of the members for a specific welfare.
     */
    public function index($id, $slug)
    {
        // 1. Fetch the welfare
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Paginate members with eager loaded relationships
        // We filter by status inside the query for better performance
        $activeMembers =WelfareMember::where('welfare_id', $welfare->id)
            ->where('status', 'active')
            ->with(['user', 'solidarityFunds'])
            ->paginate(50);

        $inactiveMembers = WelfareMember::where('welfare_id', $welfare->id)
            ->where('status', 'inactive')
            ->with(['user', 'solidarityFunds'])
            ->paginate(50);

        return view('dashboard.welfares.members.index', compact('welfare', 'activeMembers', 'inactiveMembers'));
    }

    /**
     * Remove an admin (Logic called by your show.blade.php button).
     */
    public function removeAdmin(Request $request, $id, $slug, $memberId)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        $member = WelfareMember::where('welfare_id', $welfare->id)
            ->where('id', $memberId)
            ->where('role', 'admin')
            ->firstOrFail();

        // Update the role to 'member' or remove as you see fit
        $member->update(['role' => 'member']);

        return back()->with('success', 'Admin privileges removed successfully.');
    }

    /**
     * Add an admin (Logic called by your search/add modal).
     */
    public function addAdmin(Request $request, $id, $slug)
    {
        $request->validate([
            'member_id' => 'required|exists:welfare_members,id',
        ]);

        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        $member = WelfareMember::where('welfare_id', $welfare->id)
            ->where('id', $request->member_id)
            ->firstOrFail();

        $member->update(['role' => 'admin']);

        return back()->with('success', 'Member promoted to admin successfully.');
    }

    public function search(Request $request, $welfareId)
    {
        $query = $request->get('q');
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('tsc_number', 'like', "%$query%");
            })
            ->orWhere('member_number', 'like', "%$query%")
            ->with('user')
            ->limit(10)->get();
        return response()->json($members);
    }

    public function profile($welfareId, $memberId)
    {
        $member = WelfareMember::with(['user.county', 'contributions.case'])
            ->findOrFail($memberId);

        $totalCases = WelfareBenevolenceCase::where('welfare_id', $welfareId)->count();
        $participatedCases = $member->contributions->pluck('case_id')->unique()->count();
        $percentage = $totalCases > 0 ? ($participatedCases / $totalCases) * 100 : 0;

        // Fetch participation trend (e.g., count contributions per month)
        $trendData = $member->contributions()
            ->selectRaw('DATE_FORMAT(payment_date, "%b") as month')
            ->selectRaw('count(*) as count')
            ->groupBy('month')
            ->orderByRaw('MIN(payment_date)')
            ->pluck('count', 'month');

        return view('dashboard.welfares.members.profile', compact(
            'member',
            'participatedCases',
            'totalCases',
            'percentage',
            'trendData'
        ));
    }
}
