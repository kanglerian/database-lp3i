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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function info_user($identity)
    {
        $user = User::where('identity', $identity)->where('role', '!=', 'S')->first();
        $name = $user ? $user->name : 'Tidak diketahui';
        return response()->json([
            'name' => $name,
        ]);
    }

    public function check_user($id){
        $user = User::findOrFail($id);
        $applicant = Applicant::where('identity', $user->identity)->first();
        return response()->json([
            'user' => $user,
            'applicant' => $applicant
        ]);
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
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:10', 'max:15'],
            'nik' => [
                'required',
                'min:16',
                'max:16',
                Rule::unique('applicants')->ignore($id, 'identity'),
            ],
            'kip' => [
                'nullable',
                'min:16',
                'max:16',
                Rule::unique('applicants')->ignore($id, 'identity'),
            ],
            'religion' => ['required'],
            'school' => ['required', 'max:100', 'not_in:Pilih Sekolah'],
            'year' => ['required', 'min:4', 'max:4'],
            'placeOfBirth' => ['required'],
            'dateOfBirth' => ['required'],
            'address' => ['required'],
        ], [
            'nik.required' => 'Ups, NIK-nya jangan lupa diisi ya, jangan kelewat dong!',
            'nik.unique' => 'Oops, Nomor Induk Kependudukan (NIK) sudah terdaftar nih, coba yang lain!',
            'nik.min' => 'Format NIK nggak bener, harus :min digit ya!',
            'nik.max' => 'Format NIK nggak bener, maksimal :max digit ya!',
            'kip.unique' => 'Waduh, Nomor Kartu Indonesia Pintar (KIP) sudah terdaftar nih, cari yang lain ya!',
            'kip.min' => 'Format KIP nggak bener, harus :min digit ya!',
            'kip.max' => 'Format KIP nggak bener, maksimal :max digit ya!',
            'religion.required' => 'Wajib isi agama, jangan diskip dong!',
            'school.required' => 'Pilih sekolah dulu ya, jangan bingung!',
            'year.required' => 'Tahun lulus jangan lupa diisi ya, masa lulus lupa?',
            'placeOfBirth.required' => 'Tempat lahir jangan kelewatan ya, isi sekarang!',
            'dateOfBirth.required' => 'Tanggal lahir wajib diisi, biar tahu kapan ultahnya!',
            'email.required' => 'Email nggak boleh kosong, nih. Harap diisi ya.',
            'email.email' => 'Format email nggak valid nih, coba dicek lagi.',
            'phone.required' => 'Nomor telepon jangan lupa diisi ya, biar bisa dihubungi!',
            'address.required' => 'Alamat juga jangan sampai kosong, nih. Biar bisa kirim kiriman!',
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
            'nik' => $request->nik,
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
        $validator = Validator::make($request->all(), [
            'program' => ['required'],
            'program_second' => ['required'],
        ], [
            'program.required' => 'Wajib pilih program studi, jangan sampe kosong ya!',
            'program_second.required' => 'Pilih program studi ke-2 dong, jangan sampai kosong!',
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
        $validator = Validator::make($request->all(), [
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
            'fatherName.required' => 'Nama Ayah wajib diisi, jangan lupa ya!',
            'fatherPlaceOfBirth.required' => 'Tempat lahir Ayah nggak boleh kosong, diisi dong!',
            'fatherDateOfBirth.required' => 'Tanggal lahir Ayah harus diisi nih, jangan kelewat!',
            'fatherEducation.required' => 'Pendidikan Ayah nggak boleh kosong, diisi yang bener ya!',
            'fatherJob.required' => 'Pekerjaan Ayah harus diisi, jangan lupa!',
            'fatherAddress.required' => 'Alamat Ayah nggak boleh kosong, diisi yang lengkap ya!',
            // Ibu
            'motherName.required' => 'Nama Ibu wajib diisi, jangan sampai kosong!',
            'motherPlaceOfBirth.required' => 'Tempat lahir Ibu harus diisi, jangan lupa ya!',
            'motherDateOfBirth.required' => 'Tanggal lahir Ibu nggak boleh kosong, diisi yang bener!',
            'motherEducation.required' => 'Pendidikan Ibu harus diisi, jangan lupa ya!',
            'motherJob.required' => 'Pekerjaan Ibu nggak boleh kosong, diisi yang bener!',
            'motherAddress.required' => 'Alamat Ibu wajib diisi, jangan sampai kelewat!',
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
            'phone' => $request->fatherPhone,
            'place_of_birth' => $request->fatherPlaceOfBirth,
            'date_of_birth' => $request->fatherDateOfBirth,
            'education' => $request->fatherEducation,
            'address' => $request->fatherAddress,
        ];

        $data_mother = [
            'name' => ucwords($request->motherName),
            'job' => $request->motherJob,
            'phone' => $request->motherPhone,
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
