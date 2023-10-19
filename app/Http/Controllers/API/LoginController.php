<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        $check_beasiswa = Applicant::where('email', $credentials['email'])->first();

        if ($check_beasiswa->schoolarship == '0') {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, Anda tidak memenuhi syarat untuk masuk. Hanya penerima beasiswa yang diizinkan.'
            ], 401);
        } else {
            $data = auth()->user();
            $user = User::where('identity', $data->identity)->first();
            $user->update([
                'token' => $token
            ]);

            return response()->json([
                'success' => true,
                'user' => auth()->user(),
                'token' => $token,
                'check' => $user,
            ], 200);
        }
    }
}
