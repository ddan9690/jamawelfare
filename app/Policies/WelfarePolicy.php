<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Welfare;
use App\Models\WelfareMember;
use Illuminate\Support\Facades\Session;

class WelfarePolicy
{
    // Super Admins can do everything
    public function before(User $user, $ability)
    {
        if ($user->is_super_admin) return true;
    }

    // Only Super Admins can create/delete the welfare itself
    public function delete(User $user, Welfare $welfare)
    {
        return $user->is_super_admin;
    }

    // Welfare Admins (and Super Admins) can view/edit/update
    public function manageWelfare(User $user)
    {
        $welfareId = Session::get('active_welfare_id');
        $member = WelfareMember::where('user_id', $user->id)
            ->where('welfare_id', $welfareId)
            ->first();

        return $member && $member->role === 'admin';
    }

    // Members can view the dashboard
    public function viewDashboard(User $user)
    {
        $welfareId = Session::get('active_welfare_id');
        return WelfareMember::where('user_id', $user->id)
            ->where('welfare_id', $welfareId)
            ->exists();
    }
}