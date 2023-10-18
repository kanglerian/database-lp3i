<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAll()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ])->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_user(Request $request)
    {
        $identity = $request->query('identity');
        $token = $request->query('token');
        $user = User::where(['token' => $token, 'identity' => $identity])->firstOrFail();
        $applicant = Applicant::where('identity', $user->identity)->firstOrFail();
        return response()->json([
            'success' => true,
            'user' => $user,
            'applicant' => $applicant,
        ], 201);
    }
}
