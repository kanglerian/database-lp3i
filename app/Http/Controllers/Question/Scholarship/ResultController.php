<?php

namespace App\Http\Controllers\Question\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        return view('pages.question.scholarship.index');
    }
}
