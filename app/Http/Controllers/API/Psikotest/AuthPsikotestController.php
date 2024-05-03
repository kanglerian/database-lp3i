<?php

namespace App\Http\Controllers\API\Psikotest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\School;
use App\Models\User;
use Validator;
use DateTime;

class AuthPsikotestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'school' => ['required', 'not_in:Pilih Sekolah'],
            'email' => ['required', 'email', 'max:255'],
            'class' => ['required', 'max:100'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
            ],
            'password' => ['required', 'confirmed'],
        ], [
            'name.required' => 'Oopss, sepertinya Nama Lengkap lupa diisi ya!',
            'school.required' => 'Jangan sampai lupa pilih sekolah, ya!',
            'email.required' => 'Email jangan terlewatkan, pastikan diisi ya!',
            'email.email' => 'Format email sepertinya perlu diperiksa lagi, nih!',
            'class.required' => 'Kelas jangan terlewatkan, pastikan diisi ya!',
            'phone.required' => 'Nomor telepon jangan sampai kosong, ya!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
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
        $numbers_unique = str_replace('-', '', $random_number_as_string);

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
                        'class' => $request->classes,
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                    ];
                    $user = User::create($data_user);
                    $check_phone_applicant->update($data_applicant);
                    if ($user) {
                        return response()->json([
                            'message' => 'Wohoo! Akunmu telah terdaftar! Ayo mulai masuk 💻'
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
                        'programtype_id' => $check_email_applicant->programtype_id ?? 1,
                        'followup_id' => $check_email_applicant->followup_id ?? 1,
                        'phone' => $request->phone,
                        'class' => $request->classes,
                    ];
                    $check_email_applicant->update($data_applicant);
                    $user = User::create($data_user);
                    if ($user) {
                        return response()->json([
                            'message' => 'Wohoo! Akunmu telah terdaftar! Ayo mulai masuk 💻'
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
                            'class' => $request->classes,
                            'programtype_id' => $check_phone_applicant->programtype_id ?? 1,
                            'followup_id' => $check_phone_applicant->followup_id ?? 1,
                            'source_daftar_id' => $check_phone_applicant->source_daftar_id ?? 1,
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

                        if ($user) {
                            return response()->json([
                                'message' => 'Wohoo! Akunmu telah terdaftar! Ayo mulai masuk 💻'
                            ], 201);
                        }
                    } else {
                        $data_applicant = [
                            'pmb' => $pmbValue,
                            'identity' => $numbers_unique,
                            'identity_user' => '6281313608558',
                            'name' => ucwords(strtolower($request->name)),
                            'school' => $school,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'class' => $request->classes,
                            'programtype_id' => 1,
                            'followup_id' => 1,
                            'source_id' => 1,
                            'source_daftar_id' => 1,
                            'status_id' => 2,
                            'come' => 0,
                            'isread' => '0',
                        ];

                        $data_user = [
                            'identity' => $numbers_unique,
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'password' => Hash::make($request->password),
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
                                'message' => 'Wohoo! Akunmu telah terdaftar! Ayo mulai masuk 💻'
                            ], 201);
                        }
                    }
                }
            }
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $applicant = Applicant::with('SchoolApplicant')->where('identity', $user->identity)->first();
            $exp_token = time() + (24 * 60 * 60);

            $data_token = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'school' => $applicant->schoolapplicant->name,
                'class' => $applicant->class,
                'role' => $user->role,
                'status' => $user->status,
            ];

            $data_token['exp'] = $exp_token;
            $token = Auth::guard('api')->claims($data_token)->login($user);

            return response()->json([
                'access_token' => $token,
                'message' => 'Selamat datang ' . $user->name . ' di LP3I! 🇮🇩',
            ]);
        } else {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Terima kasih, sampai jumpa!'
        ]);
    }

    public function profile()
    {
        $user = Auth::guard('api')->user();
        $applicant = Applicant::where('identity', $user->identity)->first();
        return response()->json([
            'user' => $user,
            'applicant' => $applicant,
        ]);
    }
}
