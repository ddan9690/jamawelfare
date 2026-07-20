<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Welfare;
use App\Models\WelfareMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class WelfareController extends Controller
{
    public function index()
    {

        $welfares = Welfare::with('county')->orderBy('name', 'asc')->get();
        $counties = County::all();

        return view('dashboard.welfares.index', compact('welfares', 'counties'));
    }
    public function create()
    {
        $counties = County::all();
        return view('dashboard.welfares.create', compact('counties'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50',
            'county_id' => 'required|exists:counties,id',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {

            $path = $request->file('logo')->store('welfares', 'public');

            $validated['logo'] = $path;
        }

        Welfare::create($validated);

        return redirect()->route('welfares.index')->with('success', 'Welfare created successfully.');
    }

    public function show($id, $slug)
    {
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->with(['members.user', 'membershipRequests.user'])
            ->firstOrFail();

        return view('dashboard.welfares.show', compact('welfare'));
    }


    public function edit($id, $slug)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();
        $counties = County::all();
        return view('dashboard.welfares.edit', compact('welfare', 'counties'));
    }

    public function update(Request $request, $id, $slug)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50',
            'county_id' => 'required|exists:counties,id',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($welfare->logo && \Storage::disk('public')->exists($welfare->logo)) {
                Storage::disk('public')->delete($welfare->logo);
            }

            $path = $request->file('logo')->store('welfares', 'public');
            $validated['logo'] = $path;
        }

        $validated['slug'] = Str::slug($validated['name']);

        $welfare->update($validated);

        return redirect()->route('welfares.index')->with('success', 'Welfare updated successfully.');
    }

    public function destroy($id, $slug)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();
        $welfare->delete();
        return redirect()->route('welfares.index')->with('success', 'Welfare deleted.');
    }

    public function searchMembers(Request $request, $id, $slug)
    {
        $query = $request->get('q');


        $members = WelfareMember::where('welfare_id', $id)
            ->where('status', 'active')
            ->where('role', 'member')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('tsc_number', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%");
            })
            ->with('user')
            ->limit(10)
            ->get();

        return response()->json($members);
    }

    public function addAdmin(Request $request, $id, $slug)
    {
        $request->validate([
            'member_id' => 'required|exists:welfare_members,id'
        ]);

        $member = WelfareMember::where('id', $request->member_id)
            ->where('welfare_id', $id)
            ->firstOrFail();

        $member->update(['role' => 'admin']);

        return back()->with('success', 'Member promoted to admin successfully.');
    }

    public function removeAdmin(Request $request, $id, $slug, $memberId)
    {
        $member = WelfareMember::where('id', $memberId)
            ->where('welfare_id', $id)
            ->where('role', 'admin')
            ->firstOrFail();

        $member->update(['role' => 'member']);

        return back()->with('success', 'Admin status removed successfully.');
    }

    public function toggleStatus($id, $slug)
    {
        $welfare = Welfare::where('id', $id)->where('slug', $slug)->firstOrFail();

        $welfare->status = $welfare->status === 'active' ? 'suspended' : 'active';
        $welfare->save();

        return response()->json([
            'success' => true,
            'message' => 'Welfare status updated successfully!',
            'status' => $welfare->status
        ]);
    }
}
