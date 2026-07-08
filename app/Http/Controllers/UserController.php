<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Using count directly from model as requested
        $totalUsers = User::count();
        $users = User::latest()->get();
        return view('dashboard.users.index', compact('users', 'totalUsers'));
    }

    public function show(User $user)
    {

        $user->load('welfares');
        return view('dashboard.users.show', compact('user'));
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_super_admin' => !$user->is_super_admin]);
        return response()->json(['message' => 'Status updated']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
