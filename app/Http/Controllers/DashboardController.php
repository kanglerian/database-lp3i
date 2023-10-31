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
        $daftarQuery = Applicant::query();
        $registrasiQuery = Applicant::query();
        $schoolarshipQuery = Applicant::query();
        $sourcesIdQuery = ApplicantBySourceId::query();
        $sourcesIdDaftarQuery = ApplicantBySourceDaftarId::query();

        if (Auth::user()->role === 'P') {
            $databaseQuery->where('identity_user', Auth::user()->identity);
            $applicantQuery->where('identity_user', Auth::user()->identity);
            $daftarQuery->where('identity_user', Auth::user()->identity);
            $registrasiQuery->where('identity_user', Auth::user()->identity);
            $schoolarshipQuery->where('identity_user', Auth::user()->identity);
        }
        $sourcesIdDaftarQuery->where('source_daftar_id', '!=', null);

        $databaseCount = $databaseQuery->count();
        $applicantCount = $applicantQuery->where('is_applicant', 1)->count();
        $daftarCount = $daftarQuery->where('is_daftar', 1)->count();
        $registrasiCount = $registrasiQuery->where('is_register', 1)->count();
        $schoolarshipCount = $schoolarshipQuery->where('schoolarship', 1)->count();
        $sourcesIdCount = $sourcesIdQuery->with('SourceSetting')->get();
        $sourcesIdDaftarCount = $sourcesIdDaftarQuery->with('SourceDaftarSetting')->get();

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
            'registrasiCount' => $registrasiCount,
            'schoolarshipCount' => $schoolarshipCount,
            'daftarCount' => $daftarCount,
            'sourcesIdCount' => $sourcesIdCount,
            'sourcesIdDaftarCount' => $sourcesIdDaftarCount,
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
        $daftarQuery = Applicant::query();
        $registrasiQuery = Applicant::query();

        $pmbVal = request('pmbVal', 'all');

        if (Auth::user()->role === 'P') {
            $databaseQuery->where('identity_user', Auth::user()->identity);
            $applicantQuery->where('identity_user', Auth::user()->identity);
            $daftarQuery->where('identity_user', Auth::user()->identity);
            $registrasiQuery->where('identity_user', Auth::user()->identity);
        }

        // if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
            $applicantQuery->where('pmb', $pmbVal);
            $daftarQuery->where('pmb', $pmbVal);
            $registrasiQuery->where('pmb', $pmbVal);
        // }

        $databaseCount = $databaseQuery->count();
        $applicantCount = $applicantQuery->where('is_applicant', 1)->count();
        $daftarCount = $daftarQuery->where('is_daftar', 1)->count();
        $registrasiCount = $registrasiQuery->where('is_register', 1)->count();

        return response()->json(['pmb' => $pmbVal,'database_count' => $databaseCount,'applicant_count' => $applicantCount,'daftar_count' => $daftarCount, 'registrasi_count' => $registrasiCount]);
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

        $sourcesIdDaftarQuery = ApplicantBySourceDaftarId::query();
        $sourcesIdDaftarQuery->where('source_daftar_id', '!=', null);
        $sourcesIdDaftarCount = $sourcesIdDaftarQuery->with('SourceDaftarSetting')->get();

        return response()->json(['sources' => $sourcesIdDaftarCount]);
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
