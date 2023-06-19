<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PresenterController extends Controller
{
    public function getAll()
    {
        $presenters = User::where('role', 'P')->get();

        return response()->json([
            'presenters' => $presenters,
        ])->header('Content-Type', 'application/json');;
    }
}
