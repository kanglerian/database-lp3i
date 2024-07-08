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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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

        return response()->json('oke');
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
                'school' => $applicant->schoolapplicant->name ?? 'Tidak diketahui',
                'class' => $applicant->class ?? 'Tidak diketahui',
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
