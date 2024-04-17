<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Sales;
use App\Models\Report\TargetDatabase;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function get_all()
    {
        $saleQuery = Sales::query();
        $databaseQuery = TargetDatabase::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $saleQuery->where('pmb_volume', $pmbVal);
            $saleQuery->where('pmb_revenue', $pmbVal);
            $databaseQuery->where('pmb', $pmbVal);
        }

        $sales = $saleQuery->get();
        $databases = $databaseQuery->get();

        return response()->json([
            'sales' => $sales,
            'databases' => $databases,
        ]);
    }
}
