<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function get_all()
    {
        $schools = School::all();
        return response()->json(['schools' => $schools]);
    }
}
