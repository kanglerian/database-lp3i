<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantBySourceDaftarId;
use App\Models\ApplicantBySourceId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserUpload;
use App\Models\FileUpload;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userupload = UserUpload::where(['identity_user' => Auth::user()->identity, 'fileupload_id' => 11])->get();
        $fileupload = FileUpload::where('namefile', 'bukti-pembayaran')->get();

        $databaseQuery = Applicant::query();
        $applicantQuery = Applicant::query();
        $enrollmentQuery = Applicant::query();
        $registrasiQuery = Applicant::query();
        $schoolarshipQuery = Applicant::query();
        $sourcesIdQuery = ApplicantBySourceId::query();
        $sourcesIdEnrollmentQuery = ApplicantBySourceDaftarId::query();

        if (Auth::user()->role === 'P') {
            $databaseQuery->where('identity_user', Auth::user()->identity);
            $applicantQuery->where('identity_user', Auth::user()->identity);
            $enrollmentQuery->where('identity_user', Auth::user()->identity);
            $registrasiQuery->where('identity_user', Auth::user()->identity);
            $schoolarshipQuery->where('identity_user', Auth::user()->identity);
        }
        $sourcesIdEnrollmentQuery->where('source_daftar_id', '!=', null);

        $databaseCount = $databaseQuery->count();
        $applicantCount = $applicantQuery->where('is_applicant', 1)->count();
        $enrollmentCount = $enrollmentQuery->where('is_daftar', 1)->count();
        $registrationCount = $registrasiQuery->where('is_register', 1)->count();
        $schoolarshipCount = $schoolarshipQuery->where('schoolarship', 1)->count();
        $sourcesIdCount = $sourcesIdQuery->with('SourceSetting')->get();
        $sourcesIdEnrollmentCount = $sourcesIdEnrollmentQuery->with('SourceDaftarSetting')->get();

        $databasesAdminstratorCount = Applicant::where('identity_user', '6281313608558')->count();

        $databasesAdministrator = Applicant::where('identity_user', '6281313608558')
        ->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])
        ->orderByDesc('created_at')
        ->take(10)
        ->get();

        return view('pages.dashboard.index')->with([
            'userupload' => $userupload,
            'fileupload' => $fileupload,
            'databaseCount' => $databaseCount,
            'applicantCount' => $applicantCount,
            'registrationCount' => $registrationCount,
            'schoolarshipCount' => $schoolarshipCount,
            'enrollmentCount' => $enrollmentCount,
            'sourcesIdCount' => $sourcesIdCount,
            'sourcesIdEnrollmentCount' => $sourcesIdEnrollmentCount,
            'databasesAdminstratorCount' => $databasesAdminstratorCount,
            'databasesAdministrator' => $databasesAdministrator
        ]);
    }
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_all()
    {
        $databaseQuery = Applicant::query();
        $applicantQuery = Applicant::query();
        $enrollmentQuery = Applicant::query();
        $registrasiQuery = Applicant::query();
        $schoolarshipQuery = Applicant::query();

        $identityVal = request('identity');
        $pmbVal = request('pmbVal', 'all');

        if (Auth::user()->role === 'P') {
            $databaseQuery->where('identity_user', $identityVal);
            $applicantQuery->where('identity_user', $identityVal);
            $enrollmentQuery->where('identity_user', $identityVal);
            $registrasiQuery->where('identity_user', $identityVal);
            $schoolarshipQuery->where('identity_user', $identityVal);
        }

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
            $applicantQuery->where('pmb', $pmbVal);
            $enrollmentQuery->where('pmb', $pmbVal);
            $registrasiQuery->where('pmb', $pmbVal);
            $schoolarshipQuery->where('pmb', $pmbVal);
        }

        $databaseCount = $databaseQuery->count();
        $applicantCount = $applicantQuery->where('is_applicant', 1)->count();
        $schoolarshipCount = $schoolarshipQuery->where('schoolarship', 1)->count();
        $enrollmentCount = $enrollmentQuery->where('is_daftar', 1)->count();
        $registrationCount = $registrasiQuery->where('is_register', 1)->count();

        return response()->json(['database_count' => $databaseCount, 'schoolarship_count' => $schoolarshipCount, 'applicant_count' => $applicantCount,'enrollment_count' => $enrollmentCount, 'registration_count' => $registrationCount]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_sources($pmb = null)
    {

        $sourcesIdQuery = ApplicantBySourceId::query();
        $sourcesIdCount = $sourcesIdQuery->with('SourceSetting')->get();

        return response()->json(['sources' => $sourcesIdCount]);
    }

    public function get_sources_daftar($pmb = null)
    {

        $sourcesIdEnrollmentQuery = ApplicantBySourceDaftarId::query();
        $sourcesIdEnrollmentQuery->where('source_daftar_id', '!=', null);
        $sourcesIdenrollmentCount = $sourcesIdEnrollmentQuery->with('SourceDaftarSetting')->get();

        return response()->json(['sources' => $sourcesIdenrollmentCount]);
    }

    public function get_presenters($pmb = null)
    {
        $presentersQuery = User::select('users.identity', 'users.name', DB::raw('COUNT(applicants.identity_user) as count'))
            ->leftJoin('applicants', 'users.identity', '=', 'applicants.identity_user')
            ->where('users.role', 'P')
            ->where('users.status', '1');

        if ($pmb !== 'all' && $pmb !== null) {
            $presentersQuery->where('applicants.pmb', $pmb);
        }

        $presentersQuery->groupBy('users.identity', 'users.name');
        $presenters = $presentersQuery->get();

        return response()->json(['presenters' => $presenters]);
    }

    public function quick_search($name = null)
    {
        $applicants = Applicant::with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('name', 'like', '%' . $name . '%')->get();
        return response()->json(['applicants' => $applicants]);
    }

}
