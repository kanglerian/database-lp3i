<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ReportAplikanController extends Controller
{
    public function aplikan()
    {
        $applicants = Applicant::with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('is_applicant', 1)->get();
        return response()->json([
            'applicants' => $applicants
        ]);
    }
}
