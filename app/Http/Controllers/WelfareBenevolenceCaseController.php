<?php

namespace App\Http\Controllers;

use App\Models\{WelfareBenevolenceCase, WelfareMember, BenevolenceCategory};
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

        // Ordered by user name
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
            'case_number' => 'nullable|string'
        ]);

        $welfareId = Session::get('active_welfare_id');
        $category = BenevolenceCategory::findOrFail($request->benevolence_category_id);

        // 1. Handle Case Number Logic
        if ($request->filled('case_number')) {
            $caseNumber = strtoupper($request->case_number);
        } else {
            // Fetch Welfare abbreviation
            $welfare = \App\Models\Welfare::findOrFail($welfareId);
            $abbreviation = strtoupper($welfare->abbreviation);

            // Fetch Member Number
            $member = WelfareMember::findOrFail($request->member_id);
            $memberNo = str_pad($member->member_number, 3, '0', STR_PAD_LEFT);

            // Calculate sequence (count of cases + 1)
            $nextSequence = WelfareBenevolenceCase::where('welfare_id', $welfareId)->count() + 1;
            $sequence = str_pad($nextSequence, 2, '0', STR_PAD_LEFT);

            // Format: ABBR/MEMNO/SEQ
            $caseNumber = "{$abbreviation}/{$memberNo}/{$sequence}";
        }

        WelfareBenevolenceCase::create([
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

        return redirect()->route('benevolence-cases.index')->with('success', 'Case created: ' . $caseNumber);
    }

    public function extend(Request $request, WelfareBenevolenceCase $case)
    {
        $request->validate(['new_deadline' => 'required|date|after:today']);

        $case->update(['deadline' => $request->new_deadline]);

        return back()->with('success', 'Deadline extended successfully.');
    }

    public function show($id)
    {
        $welfareId = Session::get('active_welfare_id');

        $case = WelfareBenevolenceCase::where('welfare_id', $welfareId)
            ->with(['member.user', 'category', 'contributions.member.user'])
            ->findOrFail($id);

        // Calculate total collected
        $totalCollected = $case->contributions->sum('amount');

        $members = WelfareMember::where('welfare_id', $welfareId)
            ->where('status', 'active')
            ->with('user')
            ->get();

        return view('dashboard.benevolence-cases.show', compact('case', 'members', 'totalCollected'));
    }

    public function destroy(WelfareBenevolenceCase $case)
    {
        $case->delete();
        return back()->with('success', 'Case deleted.');
    }
}
