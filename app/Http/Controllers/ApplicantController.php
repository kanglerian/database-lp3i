<?php

namespace App\Http\Controllers;

use App\Imports\ApplicantsImport;
use App\Imports\ApplicantUpdateImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Models\FollowUp;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\ApplicantStatus;
use App\Models\SourceSetting;
use App\Models\ProgramType;
use App\Models\UserUpload;
use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Database\QueryException;

use App\Exports\ApplicantsExport;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where(['status' => '1', 'role' => 'P'])->get();
        $sources = SourceSetting::all();
        $statuses = ApplicantStatus::all();
        $schools = School::all();
        $follows = FollowUp::all();
        $nopresenter = Applicant::where('identity_user', '6281313608558')->count();

        if (Auth::user()->role == 'A') {
            $total = Applicant::count();
        } else {
            $total = Applicant::where('identity_user', Auth::user()->identity)->count();
        }

        return view('pages.database.index')->with([
            'total' => $total,
            'sources' => $sources,
            'statuses' => $statuses,
            'schools' => $schools,
            'follows' => $follows,
            'users' => $users,
            'nopresenter' => $nopresenter
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
        $applicantsQuery = Applicant::query();

        $dateStart = request('dateStart', 'all');
        $dateEnd = request('dateEnd', 'all');
        $yearGrad = request('yearGrad', 'all');
        $presenterVal = request('presenterVal', 'all');
        $schoolVal = request('schoolVal', 'all');
        $majorVal = request('majorVal', 'all');
        $birthdayVal = request('birthdayVal', 'all');
        $pmbVal = request('pmbVal', 'all');
        $followVal = request('followVal', 'all');
        $comeVal = request('comeVal', 'all');
        $incomeVal = request('incomeVal', 'all');
        $planVal = request('planVal', 'all');
        $sourceVal = request('sourceVal', 'all');
        $statusVal = request('statusVal', 'all');
        $achievementVal = request('achievementVal', 'all');
        $kipVal = request('kipVal', 'all');
        $relationVal = request('relationVal', 'all');
        $jobFatherVal = request('jobFatherVal', 'all');
        $jobMotherVal = request('jobMotherVal', 'all');

        $databaseOnline = request('databaseOnline', 'all');
        $statusApplicant = request('statusApplicant', 'all');

        if (Auth::user()->role === 'P') {
            $applicantsQuery->where('identity_user', Auth::user()->identity);
        }

        if ($statusApplicant !== 'all') {
            switch ($statusApplicant) {
                case 'database':
                    $applicantsQuery->where('is_applicant', 0);
                    $applicantsQuery->where('is_daftar', 0);
                    $applicantsQuery->where('is_register', 0);
                    break;
                case 'aplikan':
                    $applicantsQuery->where('is_applicant', 1);
                    $applicantsQuery->where('is_daftar', 0);
                    $applicantsQuery->where('is_register', 0);
                    break;
                case 'daftar':
                    $applicantsQuery->where('is_applicant', 1);
                    $applicantsQuery->where('is_daftar', 1);
                    $applicantsQuery->where('is_register', 0);
                    break;
                case 'registrasi':
                    $applicantsQuery->where('is_applicant', 1);
                    $applicantsQuery->where('is_daftar', 1);
                    $applicantsQuery->where('is_register', 1);
                    break;
            }
        }

        if ($dateStart !== 'all' && $dateEnd !== 'all') {
            $applicantsQuery->whereBetween('created_at', [$dateStart, $dateEnd]);
        }

        if ($yearGrad !== 'all') {
            $applicantsQuery->where('year', $yearGrad);
        }

        if ($presenterVal !== 'all') {
            $applicantsQuery->where('identity_user', $presenterVal);
        }

        if ($schoolVal !== 'all') {
            $applicantsQuery->where('school', $schoolVal);
        }

        if ($majorVal !== 'all') {
            $applicantsQuery->where('major', 'LIKE', '%' . $majorVal . '%');
        }

        if ($birthdayVal !== 'all') {
            $applicantsQuery->where('date_of_birth', $birthdayVal);
        }

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
        }

        if ($followVal !== 'all') {
            $applicantsQuery->where('followup_id', $followVal);
        }
        if ($sourceVal !== 'all') {
            $applicantsQuery->where('source_id', $sourceVal);
        }
        if ($statusVal !== 'all') {
            $applicantsQuery->where('status_id', $statusVal);
        }
        if ($comeVal !== 'all') {
            $applicantsQuery->where('come', $comeVal);
        }
        if ($incomeVal !== 'all') {
            $applicantsQuery->where('income_parent', $incomeVal);
        }
        if ($planVal !== 'all') {
            $applicantsQuery->where('planning', $planVal);
        }
        if ($databaseOnline !== 'all') {
            $applicantsQuery->where('identity_user', $databaseOnline);
        }
        if ($achievementVal !== 'all') {
            $applicantsQuery->where('achievement', 'LIKE', '%' . $achievementVal . '%');
        }
        if ($relationVal !== 'all') {
            $applicantsQuery->where('relation', 'LIKE', '%' . $relationVal . '%');
        }
        if ($kipVal === '1') {
            $applicantsQuery->where('kip', '<>', null);
        } elseif ($kipVal === '0') {
            $applicantsQuery->whereNull('kip');
        }

        if ($jobFatherVal !== 'all') {
            $applicantsQuery->whereHas('father', function ($query) use ($jobFatherVal) {
                $query->where('job', 'LIKE', '%' . $jobFatherVal . '%');
            });
        }

        if ($jobMotherVal !== 'all') {
            $applicantsQuery->whereHas('mother', function ($query) use ($jobMotherVal) {
                $query->where('job', 'LIKE', '%' . $jobMotherVal . '%');
            });
        }

        $applicants = $applicantsQuery->with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['applicants' => $applicants]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');
            $users = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::all();
            $schools = School::all();
            $follows = FollowUp::all();

            if ($response->successful()) {
                $programs = $response->json();
            } else {
                $programs = null;
            }

            return view('pages.database.create')->with([
                'programs' => $programs,
                'statuses' => $statuses,
                'programtypes' => $programtypes,
                'sources' => $sources,
                'users' => $users,
                'schools' => $schools,
                'follows' => $follows,
            ]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pmb' => ['required', 'integer'],
                'programtype_id' => ['required', 'not_in:0'],
                'name' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'not_in:null'],
                'source_id' => ['required', 'not_in:0'],
                'status_id' => ['required', 'not_in:0'],
                'followup_id' => ['not_in:null'],
                'program' => ['required', 'string', 'not_in:0'],
                'identity_user' => ['required', 'string', 'not_in:0'],
            ]);

            $numbers_unique = mt_rand(1, 100000000000000);

            $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
            $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
            $kel = $request->input('villages') !== null ? 'DESA/KEL. ' . $request->input('villages') . ' ' : null;
            $kec = $request->input('districts') !== null ? 'KEC. ' . $request->input('districts') . ' ' : null;
            $reg = $request->input('regencies') !== null ? 'KOTA/KAB. ' . $request->input('regencies') . ' ' : null;
            $prov = $request->input('provinces') !== null ? 'PROVINSI ' . $request->input('provinces') . ' ' : null;
            $postal = $request->input('postal_code') !== null ? 'KODE POS ' . $request->input('postal_code') : null;

            $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

            $schoolCheck = School::where('id', $request->input('school'))->first();

            if ($schoolCheck) {
                $school = $schoolCheck->id;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->input('school')),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $school = School::create($dataSchool);
                $school = $school->id;
            }

            $data_applicant = [
                'identity' => $numbers_unique,
                'pmb' => $request->input('pmb'),
                'name' => ucwords(strtolower($request->input('name'))),
                'gender' => $request->input('gender'),
                'place_of_birth' => $request->input('place_of_birth'),
                'date_of_birth' => $request->input('date_of_birth'),
                'religion' => $request->input('religion'),
                'address' => $address_applicant,
                'social_media' => $request->input('social_media'),

                'email' => $request->input('email'),
                'phone' => $request->input('phone'),

                'education' => $request->input('education'),
                'school' => $school,
                'major' => $request->input('major'),
                'class' => $request->input('class'),
                'year' => $request->input('year'),
                'achievement' => $request->input('achievement'),
                'kip' => $request->input('kip'),

                'note' => $request->input('note'),
                'relation' => $request->input('relation'),

                'identity_user' => $request->input('identity_user'),
                'program' => $request->input('program'),
                'isread' => '0',
                'come' => $request->input('come') == "null" ? null : $request->input('come'),

                'known' => $request->input('known') == "null" ? null : $request->input('known'),
                'planning' => $request->input('planning') == "null" ? null : $request->input('planning'),
                'other_campus' => $request->input('other_campus'),
                'income_parent' => $request->input('income_parent') == "null" ? null : $request->input('income_parent'),

                'followup_id' => $request->input('followup_id'),
                'programtype_id' => $request->input('programtype_id'),
                'source_id' => $request->input('source_id'),
                'status_id' => $request->input('status_id'),
            ];

            $data_father = [
                'identity_user' => $numbers_unique,
                'gender' => 1,
            ];
            $data_mother = [
                'identity_user' => $numbers_unique,
                'gender' => 0,
            ];

            Applicant::create($data_applicant);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            return back()->with('message', 'Data aplikan berhasil ditambahkan!');

        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                $errorMessage = 'Terjadi duplikat data.';
                return back()->with('error', $errorMessage);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identity)
    {
        $user = Applicant::with('SchoolApplicant')->where('identity', $identity)->firstOrFail();
        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            $father = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 0])->first();

            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.profile')->with([
                'user' => $user,
                'father' => $father,
                'mother' => $mother,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chats($identity)
    {
        $user = Applicant::with('SchoolApplicant')->where('identity', $identity)->firstOrFail();

        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {

            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.chat')->with([
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
        return view('pages.database.show.chat');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function files($identity)
    {
        $user = Applicant::with('SchoolApplicant')->where('identity', $identity)->firstOrFail();
        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {

            $userupload = UserUpload::where('identity_user', $identity)->get();
            $data = [];
            foreach ($userupload as $upload) {
                $data[] = $upload->namefile;
            }
            $fileupload = FileUpload::whereNotIn('namefile', $data)->get();

            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.file')->with([
                'user' => $user,
                'userupload' => $userupload,
                'fileupload' => $fileupload,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $applicant = Applicant::findOrFail($id);
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');

            $presenters = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::all();
            $schools = School::all();
            $follows = FollowUp::all();
            $account = User::where('email', $applicant->email)->count();
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

            if ($response->successful()) {
                $programs = $response->json();
            } else {
                $programs = null;
            }

            $applicant = Applicant::with('SchoolApplicant')->findOrFail($id);
            return view('pages.database.edit')->with([
                'applicant' => $applicant,
                'programs' => $programs,
                'presenters' => $presenters,
                'programtypes' => $programtypes,
                'account' => $account,
                'father' => $father,
                'mother' => $mother,
                'sources' => $sources,
                'statuses' => $statuses,
                'schools' => $schools,
                'follows' => $follows,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        $user_detail = User::where('identity', $applicant->identity)->first();

        $request->validate([
            'pmb' => ['required', 'integer'],
            'programtype_id' => ['required', 'not_in:0'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'not_in:null'],
            'source_id' => ['required', 'not_in:0'],
            'status_id' => ['required', 'not_in:0'],
            'followup_id' => ['not_in:null'],
            'program' => ['required', 'string', 'not_in:0'],
            'identity_user' => ['required', 'string', 'not_in:0'],
        ]);

        if ($user_detail !== null) {
            $data_user = [
                'name' => ucwords(strtolower($request->input('name'))),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ];
            $user = User::findOrFail($user_detail->id);
            $user->update($data_user);
        }

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'DESA/KEL. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'KEC. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'KOTA/KAB. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'PROVINSI ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'KODE POS ' . $request->input('postal_code') : null;

        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;
        $schoolCheck = School::where('id', $request->input('school'))->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            $dataSchool = [
                'name' => strtoupper($request->input('school')),
                'region' => 'TIDAK DIKETAHUI',
            ];
            $school = School::create($dataSchool);
            $school = $school->id;
        }

        $data = [
            'pmb' => $request->input('pmb'),

            'name' => ucwords(strtolower($request->input('name'))),
            'gender' => $request->input('gender'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address') == null ? $address_applicant : $request->input('address'),
            'social_media' => $request->input('social_media'),

            'email' => $request->input('email'),
            'phone' => $request->input('phone'),

            'education' => $request->input('education'),
            'school' => $school,
            'major' => $request->input('major'),
            'class' => $request->input('class'),
            'year' => $request->input('year'),
            'achievement' => $request->input('achievement'),
            'kip' => $request->input('kip'),

            'note' => $request->input('note'),
            'relation' => $request->input('relation'),

            'identity_user' => $request->input('identity_user'),
            'program' => $request->input('program'),
            'isread' => $request->input('isread'),
            'come' => $request->input('come') == "null" ? null : $request->input('come'),

            'known' => $request->input('known') == "null" ? null : $request->input('known'),
            'planning' => $request->input('planning') == "null" ? null : $request->input('planning'),
            'other_campus' => $request->input('other_campus'),
            'income_parent' => $request->input('income_parent') == "null" ? null : $request->input('income_parent'),

            'followup_id' => $request->input('followup_id'),
            'programtype_id' => $request->input('programtype_id'),
            'source_id' => $request->input('source_id'),
            'status_id' => $request->input('status_id'),
        ];

        $father_rt = $request->input('father_rt') !== null ? 'RT. ' . $request->input('father_rt') . ' ' : null;
        $father_rw = $request->input('father_rw') !== null ? 'RW. ' . $request->input('father_rw') . ' ' : null;
        $father_kel = $request->input('father_villages') !== null ? 'DESA/KEL. ' . $request->input('father_villages') . ' ' : null;
        $father_kec = $request->input('father_districts') !== null ? 'KEC. ' . $request->input('father_districts') . ' ' : null;
        $father_reg = $request->input('father_regencies') !== null ? 'KOTA/KAB. ' . $request->input('father_regencies') . ' ' : null;
        $father_prov = $request->input('father_provinces') !== null ? 'PROVINSI ' . $request->input('father_provinces') . ' ' : null;
        $father_postal = $request->input('father_postal_code') !== null ? 'KODE POS ' . $request->input('father_postal_code') : null;

        $address_father = $father_rt . $father_rw . $father_kel . $father_kec . $father_reg . $father_prov . $father_postal;

        $data_father = [
            'name' => ucwords($request->input('father_name')),
            'job' => $request->input('father_job'),
            'place_of_birth' => $request->input('father_place_of_birth'),
            'date_of_birth' => $request->input('father_date_of_birth'),
            'education' => $request->input('father_education'),
            'phone' => strpos($request->input('father_phone'), '0') === 0 ? '62' . substr($request->input('father_phone'), 1) : $request->input('father_phone'),
            'address' => $request->input('father_address') == null ? $address_father : $request->input('father_address'),
        ];

        $mother_rt = $request->input('mother_rt') !== null ? 'RT. ' . $request->input('mother_rt') . ' ' : null;
        $mother_rw = $request->input('mother_rw') !== null ? 'RW. ' . $request->input('mother_rw') . ' ' : null;
        $mother_kel = $request->input('mother_villages') !== null ? 'DESA/KEL. ' . $request->input('mother_villages') . ' ' : null;
        $mother_kec = $request->input('mother_districts') !== null ? 'KEC. ' . $request->input('mother_districts') . ' ' : null;
        $mother_reg = $request->input('mother_regencies') !== null ? 'KOTA/KAB. ' . $request->input('mother_regencies') . ' ' : null;
        $mother_prov = $request->input('mother_provinces') !== null ? 'PROVINSI ' . $request->input('mother_provinces') . ' ' : null;
        $mother_postal = $request->input('mother_postal_code') !== null ? 'KODE POS ' . $request->input('mother_postal_code') : null;

        $address_father = $mother_rt . $mother_rw . $mother_kel . $mother_kec . $mother_reg . $mother_prov . $mother_postal;

        $data_mother = [
            'name' => ucwords($request->input('mother_name')),
            'job' => $request->input('mother_job'),
            'place_of_birth' => $request->input('mother_place_of_birth'),
            'date_of_birth' => $request->input('mother_date_of_birth'),
            'education' => $request->input('mother_education'),
            'phone' => strpos($request->input('mother_phone'), '0') === 0 ? '62' . substr($request->input('mother_phone'), 1) : $request->input('mother_phone'),
            'address' => $request->input('mother_address') == null ? $address_father : $request->input('mother_address'),
        ];

        $applicant->update($data);
        $father->update($data_father);
        $mother->update($data_mother);

        return back()->with('message', 'Data aplikan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            $family = ApplicantFamily::where('identity_user', $applicant->identity);
            $user = User::where('identity', $applicant->identity);
            $family->delete();
            $applicant->delete();
            $user->delete();
            return session()->flash('message', 'Data aplikan berhasil dihapus!');
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $applicant = Applicant::with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('identity', $id)->firstOrFail();
        $user = User::where('identity', $id)->firstOrFail();
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
            return view('pages.user.print')->with([
                'applicant' => $applicant,
                'father' => $father,
                'mother' => $mother,
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($dateStart = null, $dateEnd = null, $yearGrad = null, $schoolVal = null, $birthdayVal = null, $pmbVal = null, $sourceVal = null, $statusVal = null)
    {
        return (new ApplicantsExport($dateStart, $dateEnd, $yearGrad, $schoolVal, $birthdayVal, $pmbVal, $sourceVal, $statusVal))->download('applicants.xlsx');
    }

    public function update_data($student, $applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone = null)
    {
        $data_applicant = [
            'pmb' => $applicants[$i][2],
            'name' => !empty($applicants[$i][3]) ? ucwords(strtolower($applicants[$i][3])) : null,
            'phone' => $samePhone == null ? $phone : null,
            'education' => !empty($applicants[$i][6]) ? $applicants[$i][6] : null,
            'school' => $school ? $school->id : null,
            'major' => !empty($applicants[$i][8]) ? $applicants[$i][8] : null,
            'email' => !empty($applicants[$i][9]) && !Applicant::where('email', $applicants[$i][9])->exists() ? $applicants[$i][9] : null,
            'year' => !empty($applicants[$i][10]) ? $applicants[$i][10] : null,
            'place_of_birth' => !empty($applicants[$i][11]) ? $applicants[$i][11] : null,
            'date_of_birth' => !empty($applicants[$i][12]) ? date("Y-m-d", strtotime($applicants[$i][12])) : null,
            'gender' => $gender,
            'religion' => !empty($applicants[$i][14]) ? $applicants[$i][14] : null,
            'identity_user' => $identityUser,
            'source_id' => 7,
            'status_id' => !empty($applicants[$i][17]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][17])])->value('id') ?? 1 : 1,
            'followup_id' => $applicants[$i][18] ? FollowUp::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][18])])->value('id') ?? 1 : 1,
            'come' => $come,
            'achievement' => !empty($applicants[$i][20]) ? $applicants[$i][20] : null,
            'kip' => $kip,
            'relation' => !empty($applicants[$i][25]) ? $applicants[$i][25] : null,
            'known' => $known,
            'planning' => !empty($applicants[$i][26]) ? $applicants[$i][26] : null,
            'program' => $program,
            'other_campus' => !empty($applicants[$i][28]) ? $applicants[$i][28] : null,
            'income_parent' => !empty($applicants[$i][29]) ? $applicants[$i][29] : null,
            'social_media' => !empty($applicants[$i][30]) ? $applicants[$i][30] : null,
            'address' => $address,
        ];

        $data_father = [
            'job' => !empty($applicants[$i][21]) ? $applicants[$i][21] : null,
        ];

        $data_mother = [
            'job' => !empty($applicants[$i][22]) ? $applicants[$i][22] : null,
        ];

        $applicantFather = ApplicantFamily::where(['identity_user' => $student->identity, 'gender' => 1])->first();
        $applicantMother = ApplicantFamily::where(['identity_user' => $student->identity, 'gender' => 0])->first();

        $applicantFather->update($data_father);
        $applicantMother->update($data_mother);
        $student->update($data_applicant);
    }

    public function create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone = null)
    {

        $data_applicant = [
            'identity' => $applicants[$i][1],
            'pmb' => $applicants[$i][2],
            'name' => !empty($applicants[$i][3]) ? ucwords(strtolower($applicants[$i][3])) : null,
            'phone' => $samePhone == null ? $phone : null,
            'education' => !empty($applicants[$i][6]) ? $applicants[$i][6] : null,
            'school' => $school ? $school->id : null,
            'major' => !empty($applicants[$i][8]) ? $applicants[$i][8] : null,
            'email' => !empty($applicants[$i][9]) && !Applicant::where('email', $applicants[$i][9])->exists() ? $applicants[$i][9] : null,
            'year' => !empty($applicants[$i][10]) ? $applicants[$i][10] : null,
            'place_of_birth' => !empty($applicants[$i][11]) ? $applicants[$i][11] : null,
            'date_of_birth' => !empty($applicants[$i][12]) ? date("Y-m-d", strtotime($applicants[$i][12])) : null,
            'gender' => $gender,
            'religion' => !empty($applicants[$i][14]) ? $applicants[$i][14] : null,
            'identity_user' => $identityUser,
            'source_id' => 7,
            'status_id' => !empty($applicants[$i][17]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][17])])->value('id') ?? 1 : 1,
            'followup_id' => $applicants[$i][18] ? FollowUp::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][18])])->value('id') ?? 1 : 1,
            'come' => $come,
            'achievement' => !empty($applicants[$i][20]) ? $applicants[$i][20] : null,
            'kip' => $kip,
            'relation' => !empty($applicants[$i][25]) ? $applicants[$i][25] : null,
            'known' => $known,
            'planning' => !empty($applicants[$i][26]) ? $applicants[$i][26] : null,
            'program' => $program,
            'other_campus' => !empty($applicants[$i][28]) ? $applicants[$i][28] : null,
            'income_parent' => !empty($applicants[$i][29]) ? $applicants[$i][29] : null,
            'social_media' => !empty($applicants[$i][30]) ? $applicants[$i][30] : null,
            'address' => $address,
        ];

        ApplicantFamily::create($create_father);
        ApplicantFamily::create($create_mother);
        Applicant::create($data_applicant);
    }

    public function studentsHandle($person, $identityUser)
    {
        $response = Http::get('https://script.google.com/macros/s/AKfycbyq8NzlVbO2n8kRrkRYMDmZNjRb4aNmV0clLvAKOa5ej-XgZzTA2VL35X2VM7BMl5Br/exec?person=' . $person);

        $applicants = $response->json();


        for ($i = 1; $i < count($applicants); $i++) {

            $phone = null;

            if (!empty($applicants[$i][4])) {
                if (substr($applicants[$i][4], 0, 1) === '0') {
                    $phone = '62' . substr($applicants[$i][4], 1);
                } else {
                    $phone = '62' . $applicants[$i][4];
                }
            }

            $come = null;
            if (strcasecmp($applicants[$i][19], 'SUDAH') === 0) {
                $come = 1;
            } elseif (strcasecmp($applicants[$i][19], 'BELUM') === 0) {
                $come = 0;
            }

            $kip = null;
            if (!empty($applicants[$i][25])) {
                if (strcasecmp($applicants[$i][25], 'YA') === 0) {
                    $kip = 1;
                } else {
                    $kip = 0;
                }
            }

            $known = null;

            if (strcasecmp($applicants[$i][25], 'YA') === 0) {
                $known = 1;
            } elseif (strcasecmp($applicants[$i][25], 'TIDAK') === 0) {
                $known = 0;
            }

            $gender = null;

            if ($applicants[$i][13] === 'WANITA' || $applicants[$i][13] === 'PEREMPUAN') {
                $gender = 0;
            } elseif ($applicants[$i][13] === null) {
                $gender = null;
            } else {
                $gender = 1;
            }


            $schoolName = $applicants[$i][7];
            $school = School::where('name', $schoolName)->first();
            $program = null;

            if (!empty($applicants[$i][27])) {
                switch ($applicants[$i][27]) {
                    case 'AB':
                        $program = 'D3 Administrasi Bisnis';
                        break;
                    case 'MI':
                        $program = 'D3 Manajemen Informatika';
                        break;
                    case 'MKP':
                        $program = 'D3 Manajemen Keuangan Perbankan';
                        break;
                    case 'MP':
                        $program = 'D3 Manajemen Pemasaran';
                        break;
                    case 'TO':
                        $program = 'Teknik Otomotif Vokasi 2 Tahun';
                        break;
                    default:
                        $program = null;
                }
            }

            $dusun = !empty($applicants[$i][31]) ? ucwords($applicants[$i][31]) : null;
            $rtrw = !empty($applicants[$i][32]) ? ucwords($applicants[$i][32]) : null;
            $kelurahan = !empty($applicants[$i][33]) ? ucwords($applicants[$i][33]) : null;
            $kecamatan = !empty($applicants[$i][34]) ? ucwords($applicants[$i][34]) : null;
            $kotakab = !empty($applicants[$i][35]) ? ucwords($applicants[$i][35]) : null;
            $address = $dusun . ' ' . 'RT/RW. ' . $rtrw . ' ' . 'DESA/KEL. ' . $kelurahan . ' ' . 'KEC. ' . $kecamatan . ' ' . 'KOTA/KAB. ' . $kotakab;

            $create_father = [
                'identity_user' => $applicants[$i][1],
                'gender' => 1,
                'job' => !empty($applicants[$i][21]) ? $applicants[$i][21] : null,
            ];
            $create_mother = [
                'identity_user' => $applicants[$i][1],
                'gender' => 0,
                'job' => !empty($applicants[$i][22]) ? $applicants[$i][22] : null,
            ];

            if (!empty($applicants[$i][0]) && !empty($applicants[$i][1]) && !empty($applicants[$i][2]) && !empty($applicants[$i][3])) {
                if ($phone) {
                    $studentDataPhone = Applicant::where(['identity' => $applicants[$i][1], 'phone' => $phone])->first();
                    if ($studentDataPhone) {
                        if ($studentDataPhone->is_applicant == 0) {
                            $this->update_data($studentDataPhone, $applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother);
                        }
                    } else {
                        $studentData = Applicant::where('identity', $applicants[$i][1])->first();
                        if ($studentData) {
                            if ($studentData->is_applicant == 0) {
                                $studentPhone = Applicant::where('phone', $phone)->first();
                                if ($studentPhone) {
                                    if ($studentPhone->is_applicant == 0 && $studentPhone->is_daftar == 0 && $studentPhone->is_register == 0) {
                                        $samePhone = true;
                                        $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone);
                                    }
                                } else {
                                    $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother);
                                }

                            }
                        } else {
                            $studentPhoneDup = Applicant::where('phone', $phone)->first();
                            if ($studentPhoneDup) {
                                $samePhone = true;
                                $this->create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone);
                            } else {
                                $this->create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother);
                            }
                        }
                    }
                } else {
                    $studentData = Applicant::where('identity', $applicants[$i][1])->first();
                    if ($studentData) {
                        $samePhone = true;
                        $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone);
                    } else {
                        $samePhone = true;
                        $this->create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $address, $create_father, $create_mother, $samePhone);
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if (Auth::user()->role == 'A') {
            $this->studentsHandle('BENNY', '6282127356645');
            $this->studentsHandle('RATNA', '6282118936775');
            $this->studentsHandle('AHYAR', '6282215614238');
            $this->studentsHandle('YANTI', '6281220662033');
            $this->studentsHandle('HARLI', '6282127951392');
            $this->studentsHandle('DYANA', '6281947776090');
            return back()->with('message', 'Database berhasil diupdate dari semua Presenter.');
        } else {
            switch (Auth::user()->identity) {
                case '6282127356645':
                    $this->studentsHandle('BENNY', '6282127356645');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6282118936775':
                    $this->studentsHandle('RATNA', '6282118936775');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6281220662033':
                    $this->studentsHandle('YANTI', '6281220662033');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6282215614238':
                    $this->studentsHandle('AHYAR', '6282215614238');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6282127951392':
                    $this->studentsHandle('HARLI', '6282127951392');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6281947776090':
                    $this->studentsHandle('DYANA', '6281947776090');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                case '6281286501015':
                    $this->studentsHandle('CHECK', '6281286501015');
                    return back()->with('message', 'Database ' . Auth::user()->name . ' berhasil diupdate.');
                    break;
                default:
                    return back()->with('error', 'Presenter / Sheet tidak ditemukan.');
                    break;
            }
        }

    }

    public function import_update(Request $request)
    {
        $request->validate([
            'identity_user' => ['required', 'string', 'not_in:0'],
        ]);

        $identityUser = $request->input('identity_user');
        Excel::import(new ApplicantUpdateImport($identityUser), $request->file('berkas'));

        return back()->with('message', 'Data aplikan berhasil diupdate');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_applicant(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $data = [
            'is_applicant' => $applicant->is_applicant == 1 ? 0 : 1,
        ];
        $applicant->update($data);
        return back()->with('message', 'Data aplikan berhasil diupdate');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_daftar(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $data = [
            'is_daftar' => $applicant->is_daftar == 1 ? 0 : 1,
            'is_applicant' => $applicant->is_daftar == 1 ? 0 : 1,
        ];
        $applicant->update($data);
        return back()->with('message', 'Data aplikan berhasil diupdate');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_register(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $data = [
            'is_register' => $applicant->is_register == 1 ? 0 : 1,
            'is_daftar' => $applicant->is_register == 1 ? 0 : 1,
            'is_applicant' => $applicant->is_register == 1 ? 0 : 1,
        ];
        $applicant->update($data);
        return back()->with('message', 'Data aplikan berhasil diupdate');
    }

}
