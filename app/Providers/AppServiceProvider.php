<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Models\WelfareMember;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendOtpVerification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Register Events/Listeners for OTP
        Event::listen(
            Registered::class,
            SendOtpVerification::class
        );

        // 2. Global Authorization Gate: Super Admin bypass
        Gate::before(function ($user, $ability) {
            if ($user->is_super_admin) {
                return true;
            }
        });

        // 3. View Composer: Ensures all layout/dashboard views have welfare context
        View::composer(['layouts.dashboard', 'dashboard.index'], function ($view) {
            if (auth()->check()) {
                // Fetch all active memberships for the user
                $userWelfares = WelfareMember::with('welfare')
                    ->where('user_id', auth()->id())
                    ->where('status', 'active')
                    ->get();

                $activeWelfareId = session('active_welfare_id');

                // Auto-select the first welfare if user has memberships but no active session
                if (!$activeWelfareId && $userWelfares->isNotEmpty()) {
                    $activeWelfareId = $userWelfares->first()->welfare_id;
                    session(['active_welfare_id' => $activeWelfareId]);
                }
                
                // Get the active welfare object
                $activeWelfare = $userWelfares->firstWhere('welfare_id', $activeWelfareId)?->welfare;

                // Identify role for authorization checks
                $activeMemberRole = null;
                if ($activeWelfareId) {
                    $memberRecord = $userWelfares->firstWhere('welfare_id', $activeWelfareId);
                    $activeMemberRole = $memberRecord ? $memberRecord->role : null;
                }

                $view->with([
                    'userWelfares'     => $userWelfares,
                    'activeWelfare'    => $activeWelfare,
                    'activeMemberRole' => $activeMemberRole
                ]);
            } else {
                $view->with([
                    'userWelfares'     => collect(),
                    'activeWelfare'    => null,
                    'activeMemberRole' => null
                ]);
            }
        });
    }
}