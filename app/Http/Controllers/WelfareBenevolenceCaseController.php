<?php

namespace App\Http\Controllers;

use App\Models\{WelfareBenevolenceCase, WelfareMember, BenevolenceCategory, SolidarityFund, WelfareContribution, Welfare};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Auth};

class WelfareBenevolenceCaseController extends Controller
{
    public function index()
    {
        $cases = WelfareBenevolenceCase::with(['member.user', 'category'])
            ->where('welfare_id', Session::get('active_welfare_id'))
            ->latest()
            ->get();
        return view('dashboard.benevolence-cases.index', compact('cases'));
    }

    public function create()
    {
        $welfareId = Session::get('active_welfare_id');
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', 'active')
            ->join('users', 'welfare_members.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('welfare_members.*')
            ->with('user')
            ->get();

        $categories = BenevolenceCategory::where('welfare_id', $welfareId)->get();

        return view('dashboard.benevolence-cases.create', compact('members', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:welfare_members,id',
            'benevolence_category_id' => 'required|exists:benevolence_categories,id',
            'deadline' => 'required|date',
            'details' => 'nullable|string',
            'case_number' => 'nullable|string',
            'deduction_mode' => 'required|in:none,all,except',
            'excluded_members' => 'nullable|array',
        ]);

        $welfareId = Session::get('active_welfare_id');
        $category = BenevolenceCategory::findOrFail($request->benevolence_category_id);

        // 1. Generate Case Number
        $caseNumber = $request->filled('case_number') ? strtoupper($request->case_number)
            : $this->generateCaseNumber($welfareId, $request->member_id);

        // 2. Create Case
        $case = WelfareBenevolenceCase::create([
            'welfare_id' => $welfareId,
            'case_number' => $caseNumber,
            'member_id' => $request->member_id,
            'benevolence_category_id' => $category->id,
            'amount_to_contribute' => $category->amount,
            'deadline' => $request->deadline,
            'details' => $request->details,
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        // 3. Handle Deductions
        if ($request->deduction_mode !== 'none') {
            $query = WelfareMember::where('welfare_id', $welfareId)->where('status', 'active');

            if ($request->deduction_mode === 'except' && !empty($request->excluded_members)) {
                $query->whereNotIn('id', $request->excluded_members);
            }

            foreach ($query->get() as $member) {
                // Calculate balance (Assumes SolidarityFund has type 'deposit'/'deduction')
                $balance = SolidarityFund::where('welfare_member_id', $member->id)
                    ->selectRaw("SUM(CASE WHEN type = 'deposit' THEN amount ELSE -amount END) as balance")
                    ->value('balance') ?? 0;

                if ($balance >= $category->amount) {
                    WelfareContribution::create([
                        'welfare_benevolence_case_id' => $case->id,
                        'member_id' => $member->id,
                        'amount' => $category->amount,
                        'payment_type' => 'solidarity_fund',
                        'payment_date' => now(),
                        'recorded_by' => Auth::id(),
                    ]);

                    SolidarityFund::create([
                        'welfare_member_id' => $member->id,
                        'amount' => $category->amount,
                        'type' => 'deduction',
                        'welfare_benevolence_case_id' => $case->id,
                        'transaction_date' => now(),
                        'description' => 'Auto-deduction for case: ' . $caseNumber,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        }

        return redirect()->route('benevolence-cases.index')->with('success', 'Case created successfully.');
    }

    /**
     * Helper to generate case number
     */
    private function generateCaseNumber($welfareId, $memberId)
    {
        $welfare = Welfare::findOrFail($welfareId);
        $member = WelfareMember::findOrFail($memberId);
        $count = WelfareBenevolenceCase::where('welfare_id', $welfareId)->count() + 1;

        return strtoupper($welfare->abbreviation) . '/' .
            str_pad($member->member_number, 3, '0', STR_PAD_LEFT) . '/' .
            str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    public function extend(Request $request, WelfareBenevolenceCase $case)
    {
        $request->validate(['new_deadline' => 'required|date|after:today']);
        $case->update(['deadline' => $request->new_deadline]);
        return back()->with('success', 'Deadline extended.');
    }

    public function show($id)
    {
        $welfareId = Session::get('active_welfare_id');

        // 1. Fetch the specific case with all required relationships
        $case = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->with(['member.user', 'category', 'contributions.member.user'])
            ->findOrFail($id);

        // 2. Fetch active members for the "Record Payment" modal dropdown
        // This fixes the 'Undefined variable $members' error
        $members = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', 'active')
            ->join('users', 'welfare_members.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('welfare_members.*')
            ->with('user')
            ->get();

        // 3. Calculate total contributions
        $totalCollected = $case->contributions->sum('amount');

        // 4. Pass all necessary data to the view
        return view('dashboard.benevolence-cases.show', compact('case', 'totalCollected', 'members'));
    }

    public function destroy(WelfareBenevolenceCase $case)
    {
        $case->delete();
        return back()->with('success', 'Case deleted.');
    }

    public function updateStatus(Request $request, WelfareBenevolenceCase $case)
    {
        $request->validate(['status' => 'required|in:active,closed,suspended']);

        // If the case is being suspended, reverse solidarity fund deductions
        if ($request->status === 'suspended' && $case->status !== 'suspended') {
            $this->reverseSolidarityDeductions($case);
        }

        $case->update(['status' => $request->status]);

        return back()->with('success', 'Case status updated to ' . ucfirst($request->status));
    }

    private function reverseSolidarityDeductions($case)
    {
        // Find all contributions made via solidarity fund for this case
        $contributions = WelfareContribution::where('welfare_benevolence_case_id', $case->id)
            ->where('payment_type', 'solidarity_fund')
            ->get();

        foreach ($contributions as $contribution) {
            // 1. Create a "deposit" in SolidarityFund to reverse the "deduction"
            SolidarityFund::create([
                'welfare_member_id' => $contribution->member_id,
                'amount' => $contribution->amount,
                'type' => 'deposit', // Reverse the previous deduction
                'welfare_benevolence_case_id' => $case->id,
                'transaction_date' => now(),
                'description' => 'Reversal for suspended case: ' . $case->case_number,
                'created_by' => Auth::id(),
            ]);

            // 2. Remove the invalid contribution record
            $contribution->delete();
        }
    }
}
