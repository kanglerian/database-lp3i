<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\Organization;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAll()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ])->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_user(Request $request)
    {
        $identity = $request->query('identity');
        $token = $request->query('token');
        $user = User::where(['token' => $token, 'identity' => $identity])->firstOrFail();
        $applicant = Applicant::where('identity', $user->identity)->with(['SourceSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->firstOrFail();
        $achievements = Achievement::where('identity_user', $user->identity)->get();
        $organizations = Organization::where('identity_user', $user->identity)->get();
        return response()->json([
            'success' => true,
            'user' => $user,
            'applicant' => $applicant,
            'achievements' => $achievements,
            'organizations' => $organizations,
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $applicant = Applicant::where('identity', $id)->first();
        $user_detail = User::where('identity', $id)->first();
        $schoolCheck = School::where('id', $request->school)->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            if (strlen($request->school) < 7) {
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

        if ($user_detail) {
            $data_user = [
                'name' => ucwords(strtolower($request->name)),
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            $user = User::findOrFail($user_detail->id);
            $user->update($data_user);
        }

        $data = [
            'name' => ucwords(strtolower($request->name)),
            'gender' => $request->gender,
            'place_of_birth' => $request->placeOfBirth,
            'date_of_birth' => $request->dateOfBirth,
            'religion' => $request->religion,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'school' => $school,
            'year' => $request->year,
            'nisn' => $request->nisn,
            'kip' => $request->kip,
        ];

        $applicant->update($data);

        return response()->json(['success' => true,  'message' => 'Biodata sudah diupdate.']);
    }

    public function update_family(Request $request, $id)
    {
        $father = ApplicantFamily::where(['identity_user' => $id, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $id, 'gender' => 0])->first();

        $data_father = [
            'name' => ucwords($request->fatherName),
            'job' => $request->fatherJob,
            'place_of_birth' => $request->fatherPlaceOfBirth,
            'date_of_birth' => $request->fatherDateOfBirth,
            'education' => $request->fatherEducation,
            'address' => $request->fatherAddress,
        ];

        $data_mother = [
            'name' => ucwords($request->motherName),
            'job' => $request->motherJob,
            'place_of_birth' => $request->motherPlaceOfBirth,
            'date_of_birth' => $request->motherDateOfBirth,
            'education' => $request->motherEducation,
            'address' => $request->motherAddress,
        ];

        $father->update($data_father);
        $mother->update($data_mother);

        return response()->json(['success' => true,  'message' => 'Biodata sudah diupdate.']);
    }
}
