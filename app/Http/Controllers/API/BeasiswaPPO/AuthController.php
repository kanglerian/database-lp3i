<?php

namespace App\Http\Controllers\API\BeasiswaPPO;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\School;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot_password']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required','email','max:255','unique:users,email'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'unique:users,phone'
            ]
        ], [
            'name.required' => 'Nama jangan terlewatkan, pastikan diisi ya!',
            'email.required' => 'Email jangan terlewatkan, pastikan diisi ya!',
            'email.unique' => 'Email ini sudah terdaftar, mohon gunakan email lain!',
            'email.email' => 'Format email sepertinya perlu diperiksa lagi, nih!',
            'phone.required' => 'Nomor telepon jangan sampai kosong, ya!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.unique' => 'No. Whatsapp ini sudah terdaftar, mohon gunakan nomor telp lain!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
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

        $min = -100000000000000;
        $max = 100000000000000;
        $random_number = abs(mt_rand($min, $max));
        $random_number_as_string = (string) $random_number;
        $numbers_unique = str_replace('-', '', $random_number_as_string);

        $applicant = Applicant::where('phone', $request->phone)->first();
        if($applicant){
            return response()->json($applicant);
        } else {
            $data_applicant = [
                'identity' => $numbers_unique,
                'name' => ucwords(strtolower($request->name)),
                'phone' => $request->phone,
                'pmb' => $pmbValue,
                'identity_user' => '6281313608558',
                'source_id' => 12,
                'source_daftar_id' => 12,
                'status_id' => 1,
                'followup_id' => 1,
            ];

            $data_user = [
                'identity' => $numbers_unique,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->phone),
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
            $exp_token = time() + (24 * 60 * 60);

            $data_token = [
                'id' => $user->id,
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

    public function forgot_password(Request $request){
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

        if(!$user){
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
