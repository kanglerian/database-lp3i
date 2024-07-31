<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use Illuminate\Validation\ValidationException;

class ApplicantController extends Controller
{
    public function getAll()
    {
        $applicants = Applicant::all();
        return response()->json([
            'applicants' => $applicants,
        ])->header('Content-Type', 'application/json');
    }

    public function get_scholarship()
    {
        $applicantsQuery = Applicant::query();

        $pmbVal = request('pmbVal', 'all');
        $dateStart = request('dateStart', 'all');
        $dateEnd = request('dateEnd', 'all');

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
        }

        if ($dateStart !== 'all' && $dateEnd !== 'all') {
            $applicantsQuery->whereBetween('scholarship_date', [$dateStart, $dateEnd]);
        }

        $applicants = $applicantsQuery
            ->with(['SchoolApplicant', 'Presenter'])
            ->where('schoolarship', 1)
            ->select('identity', 'identity_user', 'pmb', 'name', 'phone', 'school', 'major', 'year', 'scholarship_date', 'program')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($applicants);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identity)
    {
        $user = Applicant::with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('identity', $identity)->first();
        $enrollment = StatusApplicantsEnrollment::where('identity_user', $identity)->first();
        $registration = StatusApplicantsRegistration::where('identity_user', $identity)->first();

        return response()->json([
            'user' => $user,
            'enrollment' => $enrollment,
            'registration' => $registration,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_website(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:15', 'min:10'],
                'school' => ['required', 'regex:/[^\s]+/'],
                'year' => ['required'],
            ]);

            $identity_val = Str::uuid();

            $number_phone = strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone');

            $check_number = Applicant::with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('phone', $number_phone)->first();

            $schoolCheck = School::where('id', $request->input('school'))->first();
            $schoolNameCheck = School::where('name', $request->input('school'))->first();

            if ($schoolCheck) {
                $school = $schoolCheck->id;
            } else {
                if ($schoolNameCheck) {
                    $school = $schoolNameCheck->id;
                } else {
                    $schoolName = strtoupper($request->input('school'));
                    if (strlen($schoolName) > 100) {
                        $schoolName = substr($schoolName, 0, 100);
                    }
                    $dataSchool = [
                        'name' => $schoolName,
                        'region' => 'TIDAK DIKETAHUI',
                    ];
                    $schoolCreate = School::create($dataSchool);
                    $school = $schoolCreate->id;
                }
            }

            if ($check_number) {
                return response()->json(['status' => true, 'message' => 'Terima kasih telah mengisi data. Kami akan segera menghubungi Anda untuk informasi lebih lanjut.', 'data' => $check_number]);
            } else {
                $data = [
                    'identity' => $identity_val,
                    'name' => ucwords(strtolower($request->input('name'))),
                    'phone' => $number_phone,
                    'school' => $school,
                    'year' => $request->input('year'),
                    'pmb' => $request->input('pmb'),
                    'programtype_id' => $request->input('programtype_id'),
                    'identity_user' => '6281313608558',
                    'source_id' => 1,
                    'source_daftar_id' => 1,
                    'status_id' => 1,
                    'followup_id' => 1,
                ];

                $data_father = [
                    'identity_user' => $identity_val,
                    'gender' => 1,
                ];
                $data_mother = [
                    'identity_user' => $identity_val,
                    'gender' => 0,
                ];

                Applicant::create($data);
                ApplicantFamily::create($data_father);
                ApplicantFamily::create($data_mother);

                return response()->json(['status' => false, 'message' => 'Terima kasih telah mengisi data. Kami akan segera menghubungi Anda untuk informasi lebih lanjut.']);
            }

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
