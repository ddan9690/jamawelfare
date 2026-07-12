<?php

namespace App\Http\Controllers;

use App\Models\{SolidarityFund, WelfareMember};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth};

class SolidarityFundController extends Controller
{
    /**
     * Display the transaction history for a specific member.
     */
    public function history($memberId)
    {
        $member = WelfareMember::findOrFail($memberId);
        $transactions = $member->solidarityFunds()->latest()->get();
        
        return view('dashboard.welfares.members.history', compact('member', 'transactions'));
    }

    /**
     * Store a new transaction OR update an existing one.
     */
    public function store(Request $request)
    {
        $request->validate([
            'welfare_member_id' => 'required|exists:welfare_members,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'transaction_id' => 'nullable|exists:solidarity_funds,id'
        ]);

        // If transaction_id is provided, we are performing an EDIT (Correction)
        if ($request->filled('transaction_id')) {
            $transaction = SolidarityFund::findOrFail($request->transaction_id);
            
            $transaction->update([
                'amount' => $request->amount,
                'description' => $request->description . ' (Edited)',
            ]);

            return back()->with('success', 'Transaction updated successfully.');
        }

        // Otherwise, create a new record (Deposit)
        // Defaulting to deposit for new payments, admin can add a type field if needed
        SolidarityFund::create([
            'welfare_member_id' => $request->welfare_member_id,
            'amount' => $request->amount,
            'type' => 'deposit', 
            'description' => $request->description,
            'transaction_date' => now(),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Payment recorded successfully.');
    }
}