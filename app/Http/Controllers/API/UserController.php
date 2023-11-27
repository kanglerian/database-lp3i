<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\FileUpload;
use App\Models\Organization;
use App\Models\School;
use App\Models\UserUpload;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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
        $account = $request->user();
        $identity = $account->identity;
        $user = User::where(['identity' => $identity])->firstOrFail();
        $applicant = Applicant::where('identity', $user->identity)->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->firstOrFail();
        $achievements = Achievement::where('identity_user', $user->identity)->get();
        $organizations = Organization::where('identity_user', $user->identity)->get();
        $userupload = UserUpload::with('fileupload')->where('identity_user', $identity)->get();
        $data = [];
        foreach ($userupload as $upload) {
            $data[] = $upload->fileupload_id;
        }
        $fileuploaded = FileUpload::whereIn('id', $data)->get();
        $fileupload = FileUpload::whereNotIn('id', $data)->get();
        return response()->json([
            'user' => $user,
            'applicant' => $applicant,
            'achievements' => $achievements,
            'organizations' => $organizations,
            'userupload' => $userupload,
            'fileupload' => $fileupload,
            'fileuploaded' => $fileuploaded,
        ], 200);
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
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'phone' => 'required',
            'nisn' => 'required',
            'religion' => 'required',
            'school' => ['required', 'not_in:Pilih Sekolah'],
            'year' => ['required'],
            'placeOfBirth' => ['required'],
            'dateOfBirth' => ['required'],
            'address' => ['required'],
        ], [
            'nisn.required' => 'NISN tidak boleh kosong.',
            'religion.required' => 'Agama tidak boleh kosong.',
            'school.required' => 'Sekolah tidak boleh kosong.',
            'year.required' => 'Tahun lulus tidak boleh kosong.',
            'placeOfBirth.required' => 'Tempat lahir tidak boleh kosong.',
            'dateOfBirth.required' => 'Tanggal lahir tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon tidak boleh kosong.',
            'address.required' => 'Alamat tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

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

        return response()->json(['success' => true, 'message' => 'Biodata sudah diupdate.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_program(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'program' => ['required'],
            'program_second' => ['required'],
        ], [
            'program.required' => 'Program studi tidak boleh kosong.',
            'program_second.required' => 'Program studi ke 2 tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $applicant = Applicant::where('identity', $id)->first();

        $data = [
            'program' => $request->program,
            'program_second' => $request->program_second,
        ];

        $applicant->update($data);

        return response()->json(['success' => true, 'message' => 'Program studi sudah diupdate.']);
    }

    public function update_family(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            // Ayah
            'fatherName' => ['required'],
            'fatherPlaceOfBirth' => ['required'],
            'fatherDateOfBirth' => ['required'],
            'fatherEducation' => ['required'],
            'fatherJob' => ['required'],
            'fatherAddress' => ['required'],
            // Mother
            'motherName' => ['required'],
            'motherPlaceOfBirth' => ['required'],
            'motherDateOfBirth' => ['required'],
            'motherEducation' => ['required'],
            'motherJob' => ['required'],
            'motherAddress' => ['required'],
        ], [
            // Ayah
            'fatherName.required' => 'Nama ayah tidak boleh kosong.',
            'fatherPlaceOfBirth.required' => 'Tempat lahir ayah tidak boleh kosong.',
            'fatherDateOfBirth.required' => 'Tanggal lahir ayah tidak boleh kosong.',
            'fatherEducation.required' => 'Pendidikan ayah tidak boleh kosong.',
            'fatherJob.required' => 'Pekerjaan ayah tidak boleh kosong.',
            'fatherAddress.required' => 'Alamat ayah tidak boleh kosong.',
            // Mother
            'motherName.required' => 'Nama ibu tidak boleh kosong.',
            'motherPlaceOfBirth.required' => 'Tempat lahir ibu tidak boleh kosong.',
            'motherDateOfBirth.required' => 'Tanggal lahir ibu tidak boleh kosong.',
            'motherEducation.required' => 'Pendidikan ibu tidak boleh kosong.',
            'motherJob.required' => 'Pekerjaan ibu tidak boleh kosong.',
            'motherAddress.required' => 'Alamat ibu tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $father = ApplicantFamily::where(['identity_user' => $id, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $id, 'gender' => 0])->first();

        $applicant = Applicant::where('identity', $id)->first();

        $data_applicant = [
            'income_parent' => $request->incomeParent,
        ];

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
        $applicant->update($data_applicant);

        return response()->json(['success' => true, 'message' => 'Biodata sudah diupdate.']);
    }
}
