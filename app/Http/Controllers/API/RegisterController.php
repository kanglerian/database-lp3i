<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\School;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:255'],
            'school' => ['required', 'not_in:Pilih Sekolah'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
            ],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        function getYearPMB()
        {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format('Y');
            $currentMonth = $currentDate->format('m');
            return $currentMonth >= 9 ? $currentYear + 1 : $currentYear;
        }

        $pmbValue = getYearPMB();

        $schoolCheck = School::where('id', $request->school)->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            if ($request->school == 'TIDAK DIKETAHUI') {
                $school = null;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->school),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $schoolCreate = School::create($dataSchool);
                $school = $schoolCreate->id;
            }
        }

        $numbers_unique = mt_rand(1, 100000000000000);

        $check_email_applicant = Applicant::where('email', $request->email)->first();
        $check_phone_applicant = Applicant::where('phone', $request->phone)->first();

        $check_email_user = User::where('email', $request->email)->first();
        $check_phone_user = User::where('phone', $request->phone)->first();

        if ($check_email_applicant) {
            if ($check_email_user) {
                if ($check_email_user->email == $request->email && $check_email_user->phone != $request->phone) {
                    return response()->json(['success' => false, 'message' => 'Email sudah digunakan. Apakah anda lupa password? Silahkan hubungi Admin.']);
                } elseif ($check_email_user->email == $request->email && $check_email_user->phone == $request->phone) {
                    return response()->json(['success' => false, 'message' => 'Email & No. Telpon ditemukan. Apakah anda lupa password? Silahkan hubungi Admin.']);
                }
            } else {
                if ($check_phone_applicant) {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $check_email_applicant->phone,
                        'password' => bcrypt($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];
                    $data_applicant = [
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                        'schoolarship' => 1,
                    ];
                    $user = User::create($data_user);
                    $check_phone_applicant->update($data_applicant);
                    if ($user) {
                        return response()->json([
                            'success' => true,
                            'user' => $user,
                        ], 201);
                    }
                } else {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $request->phone,
                        'password' => bcrypt($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];
                    $data_applicant = [
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                        'schoolarship' => 1,
                        'phone' => $request->phone,
                    ];
                    $check_email_applicant->update($data_applicant);
                    $user = User::create($data_user);
                    if ($user) {
                        return response()->json([
                            'success' => true,
                            'user' => $user,
                        ], 201);
                    }
                }
            }
        } else {
            if ($check_phone_user) {
                return response()->json(['success' => false, 'message' => 'No. Telpon sudah digunakan. Apakah anda lupa password? Silahkan hubungi Admin.']);
            } else {
                if ($check_phone_applicant) {
                    $data_applicant = [
                        'identity' => $check_phone_applicant->identity,
                        'name' => $check_phone_applicant->name,
                        'nisn' => $request->nisn,
                        'school' => $school,
                        'email' => $request->email,
                        'programtype_id' => $check_phone_applicant->programtype_id ?? 1,
                        'followup_id' => $check_phone_applicant->followup_id ?? 1,
                        'schoolarship' => 1,
                        'source_daftar_id' => 10,
                        'status_id' => 2,
                        'come' => 0,
                        'isread' => '0',
                    ];

                    $data_user = [
                        'identity' => $check_phone_applicant->identity,
                        'name' => $check_phone_applicant->name,
                        'email' => $request->email,
                        'phone' => $check_phone_applicant->phone,
                        'password' => bcrypt($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];

                    $check_phone_applicant->update($data_applicant);
                    $user = User::create($data_user);

                    if ($user) {
                        return response()->json([
                            'success' => true,
                            'user' => $user,
                        ], 201);
                    }
                } else {
                    $data_applicant = [
                        'pmb' => $pmbValue,
                        'identity' => $numbers_unique,
                        'identity_user' => '6281313608558',
                        'name' => ucwords(strtolower($request->name)),
                        'nisn' => $request->nisn,
                        'school' => $school,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'programtype_id' => 1,
                        'followup_id' => 1,
                        'schoolarship' => 1,
                        'source_id' => 10,
                        'source_daftar_id' => 10,
                        'status_id' => 2,
                        'come' => 0,
                        'isread' => '0',
                    ];

                    $data_user = [
                        'identity' => $numbers_unique,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => bcrypt($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];

                    $data_father = [
                        'identity_user' => $numbers_unique,
                        'gender' => 1,
                    ];
                    $data_mother = [
                        'identity_user' => $numbers_unique,
                        'gender' => 0,
                    ];

                    $user = User::create($data_user);
                    Applicant::create($data_applicant);
                    ApplicantFamily::create($data_father);
                    ApplicantFamily::create($data_mother);

                    if ($user) {
                        return response()->json([
                            'success' => true,
                            'user' => $user,
                        ], 201);
                    }
                }
            }
        }
    }
}
