<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\ReportStudentsAdmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportStudentsAdmissionController extends Controller
{
    public function get_all()
    {
        $databaseQuery = ReportStudentsAdmission::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $programTypeVal = request('programTypeVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session_aplikan', $sessionVal);
            $databaseQuery->where('session_daftar', $sessionVal);
        }

        if ($identityVal !== 'all') {
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($programTypeVal !== 'all') {
            $databaseQuery->where('programtype_id', $programTypeVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
