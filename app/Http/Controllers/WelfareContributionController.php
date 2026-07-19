<?php

namespace App\Http\Controllers;

use App\Models\{WelfareContribution, WelfareBenevolenceCase, WelfareMember};
use App\Models\SolidarityFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Auth, DB};

class WelfareContributionController extends Controller
{
    public function index($caseId)
    {
        $welfareId = Session::get('active_welfare_id');
        $case = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->with(['member.user', 'category', 'contributions.member.user'])
            ->findOrFail($caseId);

        $membersData = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', 'active')
            ->with('user')
            ->get()
            ->map(function ($member) use ($case) {
                // Get the existing contribution record if it exists
                $contribution = $case->contributions->where('member_id', $member->id)->first();
                $alreadyPaid = $contribution ? $contribution->amount : 0;
                
                return [
                    'id' => $member->id,
                    'name' => $member->user->name,
                    'member_number' => $member->member_number,
                    'has_contributed' => $alreadyPaid > 0,
                    'already_paid' => $alreadyPaid
                ];
            });

        return view('dashboard.contributions.index', compact('case', 'membersData'));
    }

    public function store(Request $request, $caseId)
    {
        $request->validate([
            'member_id' => 'required|exists:welfare_members,id',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|in:cash,mpesa',
            'payment_date' => 'required|date',
        ]);

        $case = WelfareBenevolenceCase::with('category')->findOrFail($caseId);
        $categoryLimit = $case->category->amount;

        // Get current contribution for this member
        $existing = WelfareContribution::where('welfare_benevolence_case_id', $caseId)
            ->where('member_id', $request->member_id)
            ->first();

        $alreadyPaid = $existing ? $existing->amount : 0;
        $remainingMemberLimit = $categoryLimit - $alreadyPaid;

        // 1. If already hit limit, send entire amount to Solidarity
        if ($remainingMemberLimit <= 0) {
            $this->saveToSolidarityFund($request, $case, "Member reached category limit of " . $categoryLimit);
            return redirect()->back()->with('success', 'Payment credited to Solidarity Fund (Limit reached).');
        }

        // 2. Logic: Split if new payment exceeds remaining limit
        if ($request->amount > $remainingMemberLimit) {
            $amountToAddToCase = $remainingMemberLimit;
            $amountToSolidarity = $request->amount - $remainingMemberLimit;

            // Update existing record with the remainder of the limit
            WelfareContribution::updateOrCreate(
                ['welfare_benevolence_case_id' => $caseId, 'member_id' => $request->member_id],
                [
                    'amount' => DB::raw("amount + $amountToAddToCase"),
                    'payment_type' => $request->payment_type,
                    'payment_date' => $request->payment_date,
                    'recorded_by' => Auth::id(),
                ]
            );

            $this->saveToSolidarityFund($request, $case, "Excess payment above category limit.", $amountToSolidarity);
            return redirect()->back()->with('success', 'Limit reached. Excess sent to Solidarity Fund.');
        }

        // 3. Default: Update existing record by adding current amount
        WelfareContribution::updateOrCreate(
            ['welfare_benevolence_case_id' => $caseId, 'member_id' => $request->member_id],
            [
                'amount' => DB::raw("amount + {$request->amount}"),
                'payment_type' => $request->payment_type,
                'payment_date' => $request->payment_date,
                'recorded_by' => Auth::id(),
            ]
        );

        return redirect()->back()->with('success', 'Contribution updated successfully.');
    }

    private function saveToSolidarityFund($request, $case, $desc, $amount = null)
    {
        SolidarityFund::create([
            'welfare_member_id' => $request->member_id,
            'amount' => $amount ?? $request->amount,
            'type' => 'deposit',
            'welfare_benevolence_case_id' => $case->id,
            'description' => $desc,
            'transaction_date' => $request->payment_date,
            'created_by' => Auth::id()
        ]);
    }
}