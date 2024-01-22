<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\StatusApplicantsApplicant;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use App\Models\UserUpload;
use Illuminate\Http\Request;

class ReportAplikanController extends Controller
{
    public function aplikan()
    {
        $databaseQuery = StatusApplicantsApplicant::query();

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

        $databases = $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant'])->get();

        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function daftar()
    {
        $databaseQuery = StatusApplicantsEnrollment::query();

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

        $databases = $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant'])->get();

        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function registrasi()
    {
        $databaseQuery = StatusApplicantsRegistration::query();

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

        $databases = $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant', 'applicant.father', 'applicant.mother', 'applicant.programtype'])->get();

        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function files()
    {
        $fileUploadsQuery = FileUpload::query();
        $usersUploadQuery = UserUpload::query();

        $usersUploadQuery->with(['userupload', 'applicant']);

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $usersUploadQuery->whereHas('applicant', function ($query) use ($pmbVal) {
                $query->where('pmb', $pmbVal);
            });
        }

        $file_uploads = $fileUploadsQuery->get();
        $users_upload = $usersUploadQuery->get();

        return response()->json([
            'file_uploads' => $file_uploads,
            'users_upload' => $users_upload,
        ]);
    }
}
