<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use Illuminate\Support\Facades\Auth;
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
                'name' => ['string', 'max:255'],
                'phone' => ['string', 'max:15', 'min:10'],
            ]);
            $numbers_unique = mt_rand(1, 100000000000000);

            $number_phone = strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone');

            $check_number = Applicant::with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('phone', $number_phone)->first();

            $schoolCheck = School::where('id', $request->school)->first();
            $schoolNameCheck = School::where('name', $request->school)->first();

            if ($schoolCheck) {
                $school = $schoolCheck->id;
            } else {
                if ($schoolNameCheck) {
                    $school = $schoolNameCheck->id;
                } else {
                    $dataSchool = [
                        'name' => strtoupper($request->school),
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
                    'identity' => $numbers_unique,
                    'name' => ucwords(strtolower($request->input('name'))),
                    'phone' => $number_phone,
                    'school' => $request->input('school'),
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
                    'identity_user' => $numbers_unique,
                    'gender' => 1,
                ];
                $data_mother = [
                    'identity_user' => $numbers_unique,
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
