<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\DatabaseByPresenterSource;
use Illuminate\Http\Request;

class DatabaseByPresenterSourceController extends Controller
{
    public function get_all() {
        $databaseQuery = DatabaseByPresenterSource::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases,
        ]);
    }
}
