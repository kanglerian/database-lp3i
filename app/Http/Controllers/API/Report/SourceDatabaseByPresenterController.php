<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\SourceDatabaseByPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SourceDatabaseByPresenterController extends Controller
{
    public function get_all()
    {
        $databaseQuery = SourceDatabaseByPresenter::query();

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
