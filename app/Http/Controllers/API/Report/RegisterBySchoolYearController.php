<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterBySchoolYear;
use Illuminate\Http\Request;

class RegisterBySchoolYearController extends Controller
{
    public function get_all()
    {
        $databaseQuery = RegisterBySchoolYear::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $wilayahVal = request('wilayahVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if($roleVal == 'P'){
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($wilayahVal !== 'all') {
            $databaseQuery->where('wilayah', $wilayahVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
