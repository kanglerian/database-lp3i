<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:255'],
            'school' => ['required', 'not_in:Pilih Sekolah'],
            'email' => ['required', 'email', 'max:255', 'unique:users', 'unique:applicants'],
            'phone' => [
                'required',
                'string',
                'unique:users',
                'unique:applicants'
            ],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $numbers_unique = mt_rand(1, 100000000000000);

        $data = [
            'identity' => $numbers_unique,
            'name' => ucwords(strtolower($request->name)),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'S',
            'status' => '0',
        ];

        $schoolCheck = School::where('id', $request->school)->first();

        if($schoolCheck){
            $school = $schoolCheck->id;
        } else {
            if($request->school == 'TIDAK DIKETAHUI'){
                $school = null;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->school),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $school = School::create($dataSchool);
                $school = $school->id;
            }
        }

        $data_applicant = [
            'identity' => $numbers_unique,
            'name' => ucwords(strtolower($request->name)),
            'school' => $school,
            'email' => $request->email,
            'phone' => $request->phone,
            'pmb' => '2024',
            'identity_user' => '6281313608558',
            'source_id' => 1,
            'status_id' => 1,
            'schoolarship' => 1,
            'come' => 0,
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

        $user = User::create($data);
        Applicant::create($data_applicant);
        ApplicantFamily::create($data_father);
        ApplicantFamily::create($data_mother);

        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
