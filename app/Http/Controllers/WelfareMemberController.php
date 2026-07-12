<?php

namespace App\Http\Controllers;

use App\Models\{Welfare, WelfareBenevolenceCase, WelfareMember, WelfareContribution};
use Illuminate\Http\Request;

class WelfareMemberController extends Controller
{
    public function index($id, $slug)
    {
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        $this->runComplianceAudit($welfare->id);

        $members = WelfareMember::where('welfare_id', $welfare->id)
            ->with(['user', 'solidarityFunds'])
            ->get()
            ->groupBy('status');

        $activeMembers = $members->get('active', collect());
        $inactiveMembers = $members->get('inactive', collect());
        $suspendedMembers = $members->get('suspended', collect());

        return view('dashboard.welfares.members.index', compact('welfare', 'activeMembers', 'inactiveMembers', 'suspendedMembers'));
    }

    private function runComplianceAudit($welfareId)
    {
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', '!=', 'inactive')
            ->get();

        $lastThreeCases = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->where('status', '!=', 'suspended')
            ->latest()
            ->take(3)
            ->get();

        if ($lastThreeCases->count() < 3) return;

        foreach ($members as $member) {
            $missedCount = 0;
            foreach ($lastThreeCases as $case) {
                $contributed = WelfareContribution::where('welfare_benevolence_case_id', $case->id)
                    ->where('member_id', $member->id)
                    ->exists();
                
                if (!$contributed) $missedCount++;
            }

            if ($missedCount >= 3 && $member->status !== 'suspended') {
                $member->update(['status' => 'suspended']);
            } elseif ($missedCount < 3 && $member->status === 'suspended') {
                $member->update(['status' => 'active']);
            }
        }
    }

    public function removeAdmin(Request $request, $id, $slug, $memberId)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        $member = WelfareMember::where('welfare_id', $welfare->id)
            ->where('id', $memberId)
            ->where('role', 'admin')
            ->firstOrFail();

        $member->update(['role' => 'member']);

        return back()->with('success', 'Admin privileges removed successfully.');
    }

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