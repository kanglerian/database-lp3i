<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'unauthorized'], 401);
        }
        $jwt_token = JWTAuth::fromUser(auth()->user());
        return response()->json([
            'access_token' => $jwt_token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'User logout'
        ]);
    }
}
