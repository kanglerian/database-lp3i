<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicantHistory;
use App\Models\Applicant;

class ApplicantHistoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_history(Request $request)
    {
        try {
            $applicant = Applicant::where('phone', $request->input('phone'))->count();
            $currentDate = date('Y-m-d');
            if ($applicant > 0) {
                $data = [
                    'phone' => $request->input('phone'),
                    'title' => $request->input('title'),
                    'date' => $currentDate,
                    'result' => $request->input('result'),
                ];
                ApplicantHistory::create($data);
                return response()->json(['message' => 'Ada']);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
