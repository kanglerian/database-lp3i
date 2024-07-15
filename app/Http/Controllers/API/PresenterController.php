<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenterController extends Controller
{
    public function get_all()
    {
        try {
            $presenters = User::where('role', 'P')
            ->select('name', 'phone')
            ->get();
        
        return response()->json($presenters);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    public function get_page()
    {
        try {
            $presenters = User::paginate(2);
        
        return response()->json($presenters);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
}
