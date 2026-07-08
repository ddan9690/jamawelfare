<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Welfare;
use App\Models\WelfareMembershipRequest;
use Illuminate\Http\Request;

class WelfareExploreController extends Controller
{
    public function index()
    {

        $welfares = Welfare::with('county')
            ->orderBy('name', 'asc')
            ->get();

        $counties = County::all();

        return view('frontend.explore', compact('welfares', 'counties'));
    }

    public function show($id, $slug)
    {
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->withCount('members')
            ->firstOrFail();

        $user = auth()->user();
        $isMember = false;
        $hasPendingRequest = false;

        if ($user) {
            $isMember = $welfare->members()->where('user_id', $user->id)->exists();
            $hasPendingRequest = $welfare->membershipRequests()
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->exists();
        }

        return view('frontend.welfare-details', compact('welfare', 'isMember', 'hasPendingRequest'));
    }

    public function store(Request $request, $id, $slug)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        // Check if user already has a pending or approved request
        $existingRequest = WelfareMembershipRequest::where('welfare_id', $welfare->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existingRequest) {
            return back()->with('error', 'You already have an existing membership request for this welfare.');
        }

        // Create the request
        WelfareMembershipRequest::create([
            'welfare_id' => $welfare->id,
            'user_id'    => auth()->id(),
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Your membership request has been sent successfully!');
    }
}
