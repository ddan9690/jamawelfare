<?php

namespace App\Http\Controllers;

use App\Models\{WelfareContribution, WelfareBenevolenceCase, WelfareMember};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Auth};

class WelfareContributionController extends Controller
{



    public function index($caseId)
    {
        $welfareId = Session::get('active_welfare_id');

        $case = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->with('member.user', 'category')
            ->findOrFail($caseId);

        $contributions = WelfareContribution::where('welfare_benevolence_case_id', $caseId)
            ->with('member.user')
            ->latest()
            ->get();

        // Get members for the Select2 dropdown
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', 'active')
            ->join('users', 'welfare_members.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('welfare_members.*')
            ->with('user')
            ->get();

        return view('dashboard.contributions.index', compact('case', 'contributions', 'members'));
    }

    /**
     * Store a new contribution record.
     */
    public function store(Request $request, $caseId)
    {
        // 1. Validate only the fields coming from the form
        $request->validate([
            'member_id' => 'required|exists:welfare_members,id',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|in:cash,mpesa',
            'payment_date' => 'required|date',
        ]);

        try {
            // 2. Create the contribution using the caseId from the URL
            WelfareContribution::create([
                'welfare_benevolence_case_id' => $caseId,
                'member_id' => $request->member_id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'payment_date' => $request->payment_date,
                'recorded_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Contribution recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to save: ' . $e->getMessage()]);
        }
    }
}
