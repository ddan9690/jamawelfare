<?php

namespace App\Http\Controllers;

use App\Models\Welfare;
use App\Models\WelfareMembershipRequest;
use App\Models\WelfareMember;
use Illuminate\Http\Request;

class WelfareMembershipRequestController extends Controller
{
    public function index($id, $slug)
    {
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        // Get all requests for audit/stats, order by latest
        $requests = WelfareMembershipRequest::where('welfare_id', $welfare->id)
            ->with('user')
            ->latest()
            ->get();

        return view('dashboard.welfares.requests.index', compact('welfare', 'requests'));
    }

    public function store(Request $request, $id, $slug)
    {
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        // Prevent duplicate applications (pending or already approved)
        $existingRequest = WelfareMembershipRequest::where('welfare_id', $welfare->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingRequest) {
            return back()->with('error', 'You already have an active or pending membership request for this welfare.');
        }

        // Create the audit trail record
        WelfareMembershipRequest::create([
            'welfare_id' => $welfare->id,
            'user_id'    => auth()->id(),
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Your membership request has been sent successfully!');
    }

    public function updateStatus(Request $request, $id, $slug, $requestId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'member_number' => 'required_if:status,approved|nullable|string|max:255|unique:welfare_members,member_number',
        ]);

        $req = WelfareMembershipRequest::where('id', $requestId)
            ->whereHas('welfare', function ($q) use ($id, $slug) {
                $q->where('id', $id)
                  ->where('slug', $slug);
            })
            ->firstOrFail();

        $req->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'approved') {

            // Prevent duplicate membership
            $existingMember = WelfareMember::where('welfare_id', $req->welfare_id)
                ->where('user_id', $req->user_id)
                ->exists();

            if (!$existingMember) {
                WelfareMember::create([
                    'welfare_id'    => $req->welfare_id,
                    'user_id'       => $req->user_id,
                    'member_number' => $request->member_number,
                    'status'        => 'active',
                    'role'          => 'member',
                ]);
            }
        }

        return back()->with('success', 'Request ' . $request->status . ' successfully.');
    }
}