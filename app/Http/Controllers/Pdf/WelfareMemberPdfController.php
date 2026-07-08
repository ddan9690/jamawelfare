<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Welfare;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class WelfareMemberPdfController extends Controller
{
    /**
     * Download the welfare members list as a PDF.
     *
     * @param  int|string  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function download($id, $slug)
    {
        // 1. Fetch the welfare with required relations
        $welfare = Welfare::where('id', $id)
            ->where('slug', $slug)
            ->with(['members.user.county'])
            ->firstOrFail();

        // 2. Authorization Check
        if (!Gate::allows('manageWelfare', $welfare) && !auth()->user()->is_super_admin) {
            abort(403);
        }

        // 3. Prepare the member collections
        $activeMembers = $welfare->members->where('status', 'active');
        $inactiveMembers = $welfare->members->where('status', '!=', 'active');

        // 4. Merge them into a single collection for the table
        $members = $activeMembers->merge($inactiveMembers);

        // 5. Generate and Download PDF
        $pdf = Pdf::loadView('dashboard.pdf.welfare_members_pdf', compact('welfare', 'members'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download(strtoupper($welfare->abbreviation) . '_MEMBERS_LIST.pdf');
    }
}