<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\WelfareBenevolenceCase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class BenevolenceContributionPdfController extends Controller
{
    public function download($welfare_id, $id)
    {
        // Added 'welfare' to the with() array
        $case = WelfareBenevolenceCase::with(['welfare', 'member.user', 'category', 'contributions.member.user'])
            ->where('welfare_id', $welfare_id)
            ->findOrFail($id);

        $totalCollected = $case->contributions->sum('amount');

        $pdf = Pdf::loadView('dashboard.pdf.contributions_report', compact('case', 'totalCollected'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('CONTRIBUTIONS_' . str_replace(' ', '_', strtoupper($case->member->user->name)) . '.pdf');
    }
}
