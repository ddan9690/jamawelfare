<?php

namespace App\Http\Controllers;

use App\Models\Welfare;
use Illuminate\Http\Request;

class WelfareRevenueController extends Controller
{
    public function index(Request $request)
    {
        $months = $request->query('months', 1);
        
        $welfares = Welfare::with(['benevolenceCases.contributions' => function($query) use ($months) {
            $query->where('created_at', '>=', now()->subMonths($months));
        }])->get();

        $data = $welfares->map(function ($welfare) {
            $totalRevenue = 0;

            foreach ($welfare->benevolenceCases as $case) {
                // Calculate revenue based on the contribution amount per case
                foreach ($case->contributions as $contribution) {
                    $totalRevenue += $this->calculateTieredFee($contribution->amount);
                }
            }

            return [
                'name' => $welfare->name,
                'abbreviation' => $welfare->abbreviation,
                'amount_due' => $totalRevenue
            ];
        })->sortByDesc('amount_due');

        return view('dashboard.revenue.index', compact('data', 'months'));
    }

    /**
     * Determine the percentage fee based on the contribution amount.
     * Tiered Logic: 
     * 0-150: 5% | 151-300: 8% | >300: 10%
     */
    private function calculateTieredFee($amount)
    {
        if ($amount <= 150) {
            return $amount * 0.05;
        } elseif ($amount <= 300) {
            return $amount * 0.08;
        } else {
            return $amount * 0.10;
        }
    }
}