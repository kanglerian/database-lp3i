<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\ReportStudentsAdmission;
use Illuminate\Http\Request;

class ReportStudentsAdmissionController extends Controller
{
    public function get_all()
    {
        $databaseQuery = ReportStudentsAdmission::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $roleVal = request('roleVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session', $sessionVal);
        }

        if ($roleVal === 'P') {
            $databaseQuery->where('identity_user', $identityVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
