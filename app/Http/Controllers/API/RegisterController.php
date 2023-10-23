<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\School;
use App\Models\User;
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

        $check_number = Applicant::with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('phone', $request->phone)->first();

        if ($check_number) {

            if ($check_number->email == $request->email || $check_number->phone == $request->phone) {
                $user_data = User::where('identity', $check_number->identity)->first();
                if ($user_data) {
                    $password_data = [
                        'password' => Hash::make($request->phone),
                    ];
                    $user_data->update($password_data);
                    return response()->json(['success' => false, 'info' => true, 'login' => true, 'message' => 'Akun sudah ditemukan. Silahkan masuk dengan akun yang sudah dikirim melalui Whatsapp!', 'user' => $user_data]);
                } else {

                    $data = [
                        'identity' => $check_number->identity,
                        'name' => $check_number->name,
                        'email' => $check_number->email ? $check_number->email : $request->email,
                        'phone' => $check_number->phone ? $check_number->phone : $request->phone,
                        'password' => bcrypt($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];

                    $data_applicant = [
                        'name' => $check_number->name,
                        'email' => $check_number->email ? $check_number->email : $request->email,
                        'phone' => $check_number->phone ? $check_number->phone : $request->phone,
                        'schoolarship' => 1,
                        'nisn' => $request->nisn,
                    ];

                    User::create($data);
                    $check_number->update($data_applicant);

                    return response()->json(['success' => false, 'info' => true, 'login' => false, 'message' => 'Email dan nomor telpon sudah ada. Apakah anda ingin melengkapi data?', 'applicant' => $check_number]);
                }
            }

        } else {
            $numbers_unique = mt_rand(1, 100000000000000);

            $data = [
                'identity' => $numbers_unique,
                'name' => ucwords(strtolower($request->name)),
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role' => 'S',
                'status' => 1,
            ];

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
                    $school = School::create($dataSchool);
                    $school = $school->id;
                }
            }

            $data_applicant = [
                'identity' => $numbers_unique,
                'name' => ucwords(strtolower($request->name)),
                'school' => $school,
                'email' => $request->email,
                'phone' => $request->phone,
                'pmb' => '2024',
                'identity_user' => '6281313608558',
                'source_id' => 8,
                'source_daftar_id' => 8,
                'status_id' => 1,
                'schoolarship' => 1,
                'come' => 0,
                'isread' => '0',
            ];

            $data_father = [
                'identity_user' => $numbers_unique,
                'gender' => 1,
            ];
            $data_mother = [
                'identity_user' => $numbers_unique,
                'gender' => 0,
            ];

            $user = User::create($data);
            Applicant::create($data_applicant);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                ], 201);
            }

            return response()->json([
                'success' => false,
            ], 409);
        }
    }
}
