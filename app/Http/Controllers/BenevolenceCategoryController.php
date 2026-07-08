<?php

namespace App\Http\Controllers;

use App\Models\BenevolenceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BenevolenceCategoryController extends Controller
{
    public function index()
    {
        $categories = BenevolenceCategory::where('welfare_id', Session::get('active_welfare_id'))->get();
        return view('dashboard.benevolence-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'amount' => 'required|numeric']);
        
        BenevolenceCategory::create([
            'welfare_id' => Session::get('active_welfare_id'),
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category created successfully!');
    }

    public function update(Request $request, BenevolenceCategory $category)
    {
        $request->validate(['name' => 'required|string|max:255', 'amount' => 'required|numeric']);

        $category->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(BenevolenceCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }
}