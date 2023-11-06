<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $schoolarship = Applicant::where(['identity' => $user->identity, 'schoolarship' => 1])->first();
            if ($schoolarship) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'id' => $user->identity,
                    'token' => $token,
                ], 200);
            } else {
                return response()->json(['message' => 'Maaf, bukan penerima beasiswa.'], 401);
            }
        } else {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }

    }
}
