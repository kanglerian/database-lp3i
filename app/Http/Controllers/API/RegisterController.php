<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\School;
use App\Models\User;

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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'school' => ['required', 'max:100', 'not_in:Pilih Sekolah'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
            ],
            'year' => ['required', 'min:4', 'max:4'],
            'password' => ['required', 'confirmed'],
        ], [
            'name.required' => 'Oopss, sepertinya Nama Lengkap lupa diisi ya!',
            'school.required' => 'Jangan sampai lupa pilih sekolah, ya!',
            'school.max' => 'Sekolah tidak boleh lebih dari 100 karakter, pastikan benar ya!',
            'email.required' => 'Email jangan terlewatkan, pastikan diisi ya!',
            'email.email' => 'Format email sepertinya perlu diperiksa lagi, nih!',
            'phone.required' => 'Nomor telepon jangan sampai kosong, ya!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
            'year.required' => 'Jangan lupa isi tahun lulus, pasti penting!',
            'password.required' => 'Password jangan lupa diisi, ya!',
            'password.confirmed' => 'Ups, konfirmasi password tidak sesuai, cek lagi ya!',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        function getYearPMB()
        {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format('Y');
            $currentMonth = $currentDate->format('m');
            return $currentMonth >= 9 ? $currentYear + 1 : $currentYear;
        }

        $pmbValue = getYearPMB();
        $identity_val = Str::uuid();

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
        $min = -100000000000000;
        $max = 100000000000000;
        $random_number = abs(mt_rand($min, $max));
        $random_number_as_string = (string) $random_number;
        $identity_val = str_replace('-', '', $random_number_as_string);

        $check_email_applicant = Applicant::where('email', $request->email)->first();
        $check_phone_applicant = Applicant::where('phone', $request->phone)->first();

        $check_email_user = User::where('email', $request->email)->first();
        $check_phone_user = User::where('phone', $request->phone)->first();

        if ($check_email_applicant) {
            if ($check_email_user) {
                if ($check_email_user->email == $request->email && $check_email_user->phone != $request->phone) {
                    return response()->json(['message' => 'Email sudah terdaftar. Silahkan hubungi Admin.'], 401);
                } elseif ($check_email_user->email == $request->email && $check_email_user->phone == $request->phone) {
                    return response()->json(['message' => 'Email & No. Telpon ditemukan. Apakah anda lupa password? Silahkan hubungi Admin.'], 401);
                }
            } else {
                if ($check_phone_applicant) {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $check_email_applicant->phone,
                        'password' => Hash::make($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];
                    $data_applicant = [
                        'year' => $request->year,
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                        'schoolarship' => 1,
                        'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
                    ];
                    $user = User::create($data_user);
                    $check_phone_applicant->update($data_applicant);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    if ($user) {
                        return response()->json([
                            'token' => $token
                        ], 201);
                    }
                } else {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $request->phone,
                        'password' => Hash::make($request->password),
                        'role' => 'S',
                        'status' => 1,
                    ];
                    $data_applicant = [
                        'year' => $request->year,
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                        'schoolarship' => 1,
                        'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
                        'phone' => $request->phone,
                    ];
                    $check_email_applicant->update($data_applicant);
                    $user = User::create($data_user);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    if ($user) {
                        return response()->json([
                            'token' => $token,
                        ], 201);
                    }
                }
            }
        } else {
            if ($check_email_user) {
                return response()->json(['message' => 'Email sudah terdaftar. Silahkan hubungi Admin.'], 401);
            } else {
                if ($check_phone_user) {
                    return response()->json(['message' => 'No. Telpon sudah terdaftar. Silahkan hubungi Admin.'], 401);
                } else {
                    if ($check_phone_applicant) {
                        $data_applicant = [
                            'identity' => $check_phone_applicant->identity,
                            'name' => $check_phone_applicant->name,
                            'school' => $school,
                            'email' => $request->email,
                            'year' => $request->year,
                            'programtype_id' => $check_phone_applicant->programtype_id ?? 1,
                            'followup_id' => $check_phone_applicant->followup_id ?? 1,
                            'schoolarship' => 1,
                            'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
                            'source_daftar_id' => $check_phone_applicant->source_daftar_id ?? 10,
                            'status_id' => 2,
                            'come' => 0,
                            'isread' => '0',
                        ];

                        $data_user = [
                            'identity' => $check_phone_applicant->identity,
                            'name' => $check_phone_applicant->name,
                            'email' => $request->email,
                            'phone' => $check_phone_applicant->phone,
                            'password' => Hash::make($request->password),
                            'role' => 'S',
                            'status' => 1,
                        ];

                        $check_phone_applicant->update($data_applicant);
                        $user = User::create($data_user);
                        $token = $user->createToken('auth_token')->plainTextToken;

                        if ($user) {
                            return response()->json([
                                'token' => $token
                            ], 201);
                        }
                    } else {
                        $data_applicant = [
                            'pmb' => $pmbValue,
                            'identity' => $identity_val,
                            'identity_user' => '6281313608558',
                            'name' => ucwords(strtolower($request->name)),
                            'school' => $school,
                            'year' => $request->year,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'programtype_id' => 1,
                            'followup_id' => 1,
                            'schoolarship' => 1,
                            'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
                            'source_id' => 10,
                            'source_daftar_id' => 10,
                            'status_id' => 2,
                            'come' => 0,
                            'isread' => '0',
                        ];

                        $data_user = [
                            'identity' => $identity_val,
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'password' => Hash::make($request->password),
                            'role' => 'S',
                            'status' => 1,
                        ];

                        $data_father = [
                            'identity_user' => $identity_val,
                            'gender' => 1,
                        ];
                        $data_mother = [
                            'identity_user' => $identity_val,
                            'gender' => 0,
                        ];
                        $user = User::create($data_user);
                        Applicant::create($data_applicant);
                        ApplicantFamily::create($data_father);
                        ApplicantFamily::create($data_mother);
                        $token = $user->createToken('auth_token')->plainTextToken;
                        if ($user) {
                            return response()->json([
                                'token' => $token
                            ], 201);
                        }
                    }
                }
            }
        }
    }
}
