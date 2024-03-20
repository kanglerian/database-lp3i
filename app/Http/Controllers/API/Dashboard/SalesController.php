<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function get_all()
    {
        $databaseQuery = Sales::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb_volume', $pmbVal);
            $databaseQuery->where('pmb_revenue', $pmbVal);
        }

        $databases = $databaseQuery->get();

        return response()->json([
            'databases' => $databases
        ]);
    }
}
