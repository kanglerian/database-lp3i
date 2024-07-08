<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function kkn(){
        return view("data.kkn.index");
    }
}
