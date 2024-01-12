<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\DatabaseByPresenterSource;
use Illuminate\Http\Request;

class DatabaseByPresenterSourceController extends Controller
{
    public function get_all() {
        $databases = DatabaseByPresenterSource::all();
        return response()->json([
            'databases' => $databases,
        ]);
    }
}
