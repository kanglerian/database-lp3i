<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\TargetByMonth;
use Illuminate\Http\Request;

class TargetByMonthController extends Controller
{
    public function get_all()
    {
        $databaseQuery = TargetByMonth::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb_volume', $pmbVal);
            $databaseQuery->where('pmb_revenue', $pmbVal);
        }

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases,
        ]);
    }
}
