<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index()
    {
        $applicants = Applicant::all();
        return response()->json([
            'total' => count($applicants),
            'applicants' => $applicants,
        ])->header('Content-Type', 'application/json');
    }
}
