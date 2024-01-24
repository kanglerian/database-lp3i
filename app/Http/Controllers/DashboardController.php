<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantBySourceDaftarId;
use App\Models\ApplicantBySourceId;
use App\Models\ProgramType;
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
            // Database
            'databaseCount' => $databaseCount,
            // Applicant
            'applicantCount' => $applicantCount,
            'registrationCount' => $registrationCount,
            'schoolarshipCount' => $schoolarshipCount,
            'enrollmentCount' => $enrollmentCount,
            'sourcesIdCount' => $sourcesIdCount,
            'sourcesIdEnrollmentCount' => $sourcesIdEnrollmentCount,
            'databasesAdminstratorCount' => $databasesAdminstratorCount,
            'databasesAdministrator' => $databasesAdministrator,
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

        $identityVal = request('identityVal', 'all');
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
        $databasePhone = $databaseQuery->whereNotNull('phone')->get();
        $applicantCount = $applicantQuery->where('is_applicant', 1)->count();
        $schoolarshipCount = $schoolarshipQuery->where('schoolarship', 1)->count();
        $enrollmentCount = $enrollmentQuery->where('is_daftar', 1)->count();
        $registrationCount = $registrasiQuery->where('is_register', 1)->count();

        return response()->json([
            'database_count' => $databaseCount,
            'database_phone' => $databasePhone,
            'schoolarship_count' => $schoolarshipCount,
            'applicant_count' => $applicantCount,
            'enrollment_count' => $enrollmentCount,
            'registration_count' => $registrationCount,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_presenter()
    {
        $presenters = [];
        if (Auth::user()->role == 'A') {
            $presenters = User::where('role', 'P')->get();
        } elseif (Auth::user()->role == 'P') {
            $presenters = User::where('identity', Auth::user()->identity)->get();
        } elseif (Auth::user()->role == 'K'){
            $presenters = User::where('role', 'P')->get();
        }

        return response()->json([
            'presenters' => $presenters
        ]);
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

    public function quick_search_status()
    {
        $applicantsQuery = Applicant::query();

        $pmbVal = request('pmbVal', 'all');
        $statusApplicant = request('statusApplicant', 'all');

        if (Auth::user()->role === 'P') {
            $applicantsQuery->where('identity_user', Auth::user()->identity);
        }

        if ($statusApplicant !== 'all') {
            switch ($statusApplicant) {
                case 'aplikan':
                    $applicantsQuery->where('is_applicant', 1);
                    break;
                case 'daftar':
                    $applicantsQuery->where('is_daftar', 1);
                    break;
                case 'registrasi':
                    $applicantsQuery->where('is_register', 1);
                    break;
                case 'schoolarship':
                    $applicantsQuery->where('schoolarship', 1);
                    break;
            }
        }

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
        }

        $applicants = $applicantsQuery->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->orderByDesc('created_at')->get();

        return response()->json(['applicants' => $applicants]);
    }
    public function quick_search_source()
    {
        $applicantsQuery = Applicant::query();

        $pmbVal = request('pmbVal', 'all');
        $source = request('source', 'all');

        if (Auth::user()->role === 'P') {
            $applicantsQuery->where('identity_user', Auth::user()->identity);
        }

        if ($source !== 'all') {
            $applicantsQuery->where('source_daftar_id', $source);
        }

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
        }

        $applicants = $applicantsQuery->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->orderByDesc('created_at')->get();

        return response()->json(['applicants' => $applicants]);
    }

    public function history_page()
    {
        return view('pages.dashboard.history');
    }

    public function rekapitulasi_page()
    {
        return view('pages.dashboard.rekapitulasi');
    }

    public function aplikan_page()
    {
        return view('pages.dashboard.aplikan');
    }

    public function persyaratan_page()
    {
        return view('pages.dashboard.persyaratan');
    }
    public function perolehan_pmb_page()
    {
        $program_types = ProgramType::all();
        return view('pages.dashboard.perolehan-pmb')->with([
            'program_types' => $program_types,
        ]);
    }
}
