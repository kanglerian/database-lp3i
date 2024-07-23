<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index()
    {
        $applicants = Applicant::paginate(10);
        return view("coba")->with([
            'applicants' => $applicants
        ]);
    }
}
