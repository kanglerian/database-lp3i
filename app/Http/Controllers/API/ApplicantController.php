<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Validation\ValidationException;

class ApplicantController extends Controller
{
    public function getAll()
    {
        $applicants = Applicant::all();

        return response()->json([
            'applicants' => $applicants,
        ])->header('Content-Type', 'application/json');;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_website(Request $request)
    {
        try {
            $request->validate([
                'name' => ['string', 'max:255'],
                'phone' => ['string', 'max:15', 'min:10'],
                'year' => ['string', 'digits:4'],
                'source' => ['integer', 'max:10', 'not_in:Pilih sumber'],
                'status' => ['integer', 'max:10', 'not_in:Pilih status'],
                'isread' => ['boolean'],
            ]);
            $data = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'year' => $request->input('year'),
                'source' => 1,
                'status' => 1,
                'isread' => 0,
            ];
            
            Applicant::create($data);
            return response()->json(['message' => 'POST request handled successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
