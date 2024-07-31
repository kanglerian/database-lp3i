<?php

namespace App\Http\Controllers\API\BeasiswaPPO;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\FileUpload;
use App\Models\School;
use App\Models\User;
use App\Models\UserUpload;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot_password', 'profile_by_phone']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'unique:users,phone'
            ],
            'information' => ['required', 'max:16', 'min:10']
        ], [
            'name.required' => 'Nama jangan terlewatkan, pastikan diisi ya!',
            'email.required' => 'Email jangan terlewatkan, pastikan diisi ya!',
            'email.unique' => 'Email ini sudah terdaftar, mohon gunakan email lain!',
            'email.email' => 'Format email sepertinya perlu diperiksa lagi, nih!',
            'phone.required' => 'Nomor telepon jangan sampai kosong, ya!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.unique' => 'No. Whatsapp ini sudah terdaftar, mohon gunakan nomor telp lain!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
            'information.required' => 'Sumber informasi jangan terlewatkan, pastikan diisi ya!',
            'information.min' => 'Sumber informasi tidak tepat!',
            'information.max' => 'Sumber informasi tidak tepat!',
        ]);

        if ($validator->fails()) {
            return response()->json(['validate' => true, 'message' => $validator->errors()], 422);
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

        $applicant = Applicant::where('phone', $request->phone)->first();
        if ($applicant) {

            $data_applicant = [
                'email' => $request->email,
                'source_daftar_id' => 12,
                'status_id' => 1,
                'followup_id' => 1,
            ];

            $data_user = [
                'identity' => $applicant->identity,
                'name' => $applicant->name,
                'email' => $request->email,
                'phone' => $applicant->phone,
                'password' => Hash::make($applicant->phone),
                'role' => 'S',
                'status' => 1,
            ];

            User::create($data_user);
            $applicant->update($data_applicant);

            $credentials = [
                'email' => $applicant->email,
                'password' => $applicant->phone,
            ];

            if (Auth::attempt($credentials)) {
                $user_attempt = Auth::user();
                $exp_token = time() + (24 * 60 * 60);

                $data_token = [
                    'id' => $user_attempt->id,
                    'name' => $user_attempt->name,
                    'email' => $user_attempt->email,
                    'phone' => $user_attempt->phone,
                    'role' => $user_attempt->role,
                    'status' => $user_attempt->status,
                ];

                $data_token['exp'] = $exp_token;
                $token = Auth::guard('api')->claims($data_token)->login($user_attempt);

                return response()->json([
                    'access_token' => $token,
                    'message' => 'Selamat datang ' . $user_attempt->name . ' di LP3I! 🇮🇩',
                ]);
            }
        } else {
            $presenter = User::where(['role' => 'P', 'phone' => $request->information])->first();

            $data_applicant = [
                'identity' => $identity_val,
                'name' => ucwords(strtolower($request->name)),
                'phone' => $request->phone,
                'email' => $request->email,
                'pmb' => $pmbValue,
                'identity_user' => $presenter ? $request->information : '6281313608558',
                'source_id' => 12,
                'source_daftar_id' => 12,
                'status_id' => 1,
                'followup_id' => 1,
            ];

            $data_user = [
                'identity' => $identity_val,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->phone),
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

            User::create($data_user);
            Applicant::create($data_applicant);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            $credentials = [
                'email' => $request->email,
                'password' => $request->phone,
            ];

            if (Auth::attempt($credentials)) {
                $user_attempt = Auth::user();
                $exp_token = time() + (24 * 60 * 60);

                $data_token = [
                    'identity' => $identity_val,
                    'name' => $user_attempt->name,
                    'email' => $user_attempt->email,
                    'phone' => $user_attempt->phone,
                    'role' => $user_attempt->role,
                    'status' => $user_attempt->status,
                ];

                $data_token['exp'] = $exp_token;
                $token = Auth::guard('api')->claims($data_token)->login($user_attempt);

                return response()->json([
                    'access_token' => $token,
                    'message' => 'Selamat datang ' . $user_attempt->name . ' di LP3I! 🇮🇩',
                ]);
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
            $applicant = Applicant::where('identity', $user->identity)->first();
            $exp_token = time() + (24 * 60 * 60);

            $data_token = [
                'identity' => $applicant->identity,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
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
        try {
            Auth::guard('api')->logout();
            return response()->json([
                'message' => 'Terima kasih, sampai jumpa!'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function profile_by_phone(Request $request)
    {
        try {
            $applicant = Applicant::with(['SchoolApplicant', 'presenter'])->where('phone', $request->phone)->first();
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
            $foto = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'foto');
            })->first();
            $akta_kelahiran = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'akta-kelahiran');
            })->first();
            $sertifikat_pendukung = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'sertifikat-pendukung');
            })->first();
            $foto_rumah = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'foto-rumah-luar-dan-dalam');
            })->first();
            $bukti_tarif_daya = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'bukti-tarif-daya-listrik');
            })->first();
            if ($applicant->name && $applicant->gender !== null && $applicant->place_of_birth && $applicant->date_of_birth && $applicant->religion && $applicant->school && $applicant->major && $applicant->religion && $applicant->class && $applicant->year && $applicant->income_parent && $applicant->social_media && $applicant->address && $applicant->program && $applicant->program_second && $father->name && $father->name && $father->date_of_birth && $father->place_of_birth && $father->phone && $father->education && $father->job && $father->address && $mother->name && $mother->name && $mother->date_of_birth && $mother->place_of_birth && $mother->phone && $mother->education && $mother->job && $mother->address && $foto && $akta_kelahiran && $sertifikat_pendukung && $foto_rumah && $bukti_tarif_daya) {
                return response()->json([
                    'applicant' => [
                        'identity' => $applicant->identity,
                        'name' => $applicant->name,
                        'email' => $applicant->email,
                        'phone' => $applicant->phone,
                        'school_id' => $applicant->school,
                        'school' => $applicant->school ? $applicant->SchoolApplicant->name : null,
                        'major' => $applicant->major,
                        'class' => $applicant->class,
                        'year' => $applicant->year,
                        'presenter' => $applicant->presenter->name,
                        'no_presenter' => $applicant->presenter->phone,
                    ],
                    'finish' => true,
                ]);
            } else {
                return response()->json([
                    'applicant' => [],
                    'finish' => false,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function profile()
    {
        try {
            $user = Auth::guard('api')->user();
            $applicant = Applicant::with('SchoolApplicant')->where('identity', $user->identity)->first();
            $father = ApplicantFamily::where(['identity_user' => $user->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $user->identity, 'gender' => 0])->first();
            $userupload = UserUpload::with('fileupload')->where('identity_user', $user->identity)->get();
            $data = [];
            foreach ($userupload as $upload) {
                $data[] = $upload->fileupload_id;
            }
            $fileuploaded = FileUpload::whereIn('id', $data)->get();
            $fileupload = FileUpload::whereNotIn('id', $data)
                ->whereIn('namefile', [
                    "foto",
                    "akta-kelahiran",
                    "kartu-keluarga",
                    "sertifikat-pendukung",
                    "foto-rumah-luar-dan-dalam",
                    "bukti-tarif-daya-listrik",
                ])->get();

            $foto = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'foto');
            })->first();
            $akta_kelahiran = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'akta-kelahiran');
            })->first();
            $sertifikat_pendukung = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'sertifikat-pendukung');
            })->first();
            $foto_rumah = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'foto-rumah-luar-dan-dalam');
            })->first();
            $bukti_tarif_daya = UserUpload::with('fileupload')->where('identity_user', $applicant->identity)->whereHas('fileupload', function ($query) {
                $query->where('namefile', 'bukti-tarif-daya-listrik');
            })->first();

            $validate_data = $applicant->name && $applicant->gender !== null && $applicant->place_of_birth && $applicant->date_of_birth && $applicant->religion && $applicant->school && $applicant->major && $applicant->religion && $applicant->class && $applicant->year && $applicant->income_parent && $applicant->social_media && $applicant->address ? true : false;
           
            $validate_program = $applicant->program && $applicant->program_second ? true : false;

            $validate_father = $father->name && $father->date_of_birth && $father->place_of_birth && $father->phone && $father->education && $father->job && $father->address ? true : false;

            $validate_mother = $mother->name && $mother->date_of_birth && $mother->place_of_birth && $mother->phone && $mother->job && $mother->address ? true : false;
            
            $validate_berkas = $foto && $akta_kelahiran && $sertifikat_pendukung && $foto_rumah && $bukti_tarif_daya ? true : false;

            $validate = $validate_data && $validate_program && $validate_father && $validate_mother && $validate_berkas ? true : false;

            return response()->json([
                'applicant' => [
                    'identity' => $applicant->identity,
                    'name' => $applicant->name,
                    'avatar' => $user->avatar,
                    'gender' => $applicant->gender,
                    'religion' => $applicant->religion,
                    'place_of_birth' => $applicant->place_of_birth,
                    'date_of_birth' => $applicant->date_of_birth,
                    'address' => $applicant->address,
                    'school_id' => $applicant->school,
                    'major' => $applicant->major,
                    'class' => $applicant->class,
                    'year' => $applicant->year,
                    'program' => $applicant->program,
                    'program_second' => $applicant->program_second,
                    'income_parent' => $applicant->income_parent,
                    'social_media' => $applicant->social_media,
                    'role' => $user->role,
                    'status' => $user->status,
                    'school' => $applicant->school ? $applicant->SchoolApplicant->name : null
                ],
                'father' => [
                    'name' => $father->name,
                    'phone' => $father->phone,
                    'place_of_birth' => $father->place_of_birth,
                    'date_of_birth' => $father->date_of_birth,
                    'job' => $father->job,
                    'education' => $father->education,
                    'address' => $father->address,
                ],
                'mother' => [
                    'name' => $mother->name,
                    'phone' => $mother->phone,
                    'place_of_birth' => $mother->place_of_birth,
                    'date_of_birth' => $mother->date_of_birth,
                    'job' => $mother->job,
                    'education' => $mother->education,
                    'address' => $mother->address,
                ],
                'userupload' => $userupload,
                'fileupload' => $fileupload,
                'fileuploaded' => $fileuploaded,
                'validate' => [
                    'validate' => $validate,
                    'validate_data' => $validate_data,
                    'validate_program' => $validate_program,
                    'validate_father' => $validate_father,
                    'validate_mother' => $validate_mother,
                    'validate_berkas' => $validate_berkas,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => [
                'required',
                'min:10',
                'max:15',
            ]
        ], [
            'phone.required' => 'Nomor telepon jangan sampai kosong, ya!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
        ]);

        if ($validator->fails()) {
            return response()->json(['validate' => true, 'message' => $validator->errors()], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User dengan nomor telepon ini tidak ditemukan.'], 404);
        }

        $user->update([
            'password' => Hash::make($user->phone),
        ]);
        $data = [
            'name' => $user->name,
            'phone' => $request->phone,
            'email' => $user->email,
        ];
        return response()->json($data, 200);
    }
}
