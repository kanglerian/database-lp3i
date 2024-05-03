<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function get_all()
    {
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $schoolVal = request('schoolVal', 'all');
        $yearVal = request('yearVal', 'all');

        $recommendationQuery = Recommendation::query();
        if($roleVal == 'A'){
            if($identityVal !== 'all'){
                $recommendationQuery->whereHas('applicant', function ($query) use ($identityVal) {
                    $query->where('identity_user', $identityVal);
                });
            }
        } else {
            $recommendationQuery->whereHas('applicant', function ($query) use ($identityVal) {
                $query->where('identity_user', $identityVal);
            });
        }

        if($schoolVal !== 'all'){
            $recommendationQuery->where('school_id', $schoolVal);
        }

        if($yearVal !== 'all'){
            $recommendationQuery->where('year', $yearVal);
        }

        $recommendations = $recommendationQuery->with(['applicant','schoolapplicant','applicant.presenter'])->get();
        return response()->json([
            'recommendations' => $recommendations,
        ])->header('Content-Type', 'application/json');
    }
}