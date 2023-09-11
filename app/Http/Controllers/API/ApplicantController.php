<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApplicantController extends Controller
{
    public function getAll()
    {
        $applicants = Applicant::all();
        return response()->json([
            'applicants' => $applicants,
        ])->header('Content-Type', 'application/json');
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
            ]);
            $numbers_unique = mt_rand(1, 1000000000);

            $data = [
                'identity' => $numbers_unique,
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'pmb' => $request->input('pmb'),
                'programtype_id' => $request->input('programtype_id'),
                'source_id' => 1,
                'status' => 1,
                'isread' => '0',
            ];

            $data_father = [
                'identity_user' => $numbers_unique,
                'gender' => 1,
            ];
            $data_mother = [
                'identity_user' => $numbers_unique,
                'gender' => 0,
            ];
            
            Applicant::create($data);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            return response()->json(['message' => 'Terima kasih telah mengisi form. tunggu sampai bidang terkait menghubungimu ya']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
