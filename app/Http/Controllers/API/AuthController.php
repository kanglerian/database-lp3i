<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(
            array_merge(
                $validator->validated(),
                [
                    'password' => Hash::make($request->input('password')),
                    'role' => 'S',
                    'status' => '1',
                ],
            )
        );
        return response()->json([
            'message' => 'Registration success!',
            'user' => $user
        ]);

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $expirationTime = time() + (24 * 60 * 60);
            $data = [
                'id' => $user->id,
                'identity' => $user->identity,
                'avatar' => $user->avatar,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'role' => $user->role,
                'status' => $user->status,
                'exp' => $expirationTime,
            ];

            $token = Auth::guard('api')->claims($data)->login($user);
            return response()->json([
                'access_token' => $token,
                'message' => 'Berhasil masuk!'
            ]);
        } else {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'User logout'
        ]);
    }

    public function profile()
    {
        $user = Auth::guard('api')->user();
        return response()->json($user);
    }
}
