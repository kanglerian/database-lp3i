<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presenter;

class PresenterController extends Controller
{
    public function getAll()
    {
        $presenters = Presenter::all();

        return response()->json([
            'presenters' => $presenters,
        ])->header('Content-Type', 'application/json');;
    }
}
