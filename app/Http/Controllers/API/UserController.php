<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}