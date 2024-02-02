<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterBySchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterBySchoolController extends Controller
{
    public function get_all()
    {
        $databaseQuery = RegisterBySchool::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $statusVal = request('statusVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if($roleVal == 'P'){
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($statusVal !== 'all') {
            $databaseQuery->where('status', $statusVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
