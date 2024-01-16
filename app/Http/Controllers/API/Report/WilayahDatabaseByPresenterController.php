<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\WilayahDatabaseByPresenter;
use Illuminate\Http\Request;

class WilayahDatabaseByPresenterController extends Controller
{
    public function get_all() {
        $databaseQuery = WilayahDatabaseByPresenter::query();

        $pmbVal = request('pmbVal', 'all');
        $identityUserVal = request('identityUserVal', 'all');
        $roleVal = request('roleVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($roleVal === 'P') {
            $databaseQuery->where('identity_user', $identityUserVal);
        }

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases,
        ]);
    }
}
