<?php

namespace App\Http\Controllers\API\BeasiswaPPO;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\School;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    public function update(Request $request, $identity){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1', 'max:150'],
            'gender' => ['required', 'not_in:null'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required'],
            'religion' => ['required'],
            'school' => ['required'],
            'major' => ['required','min:1','max:100'],
            'class' => ['required','min:1','max:100'],
            'year' => ['required','min:4','max:4'],
            'income_parent' => ['required'],
            'social_media' => ['required','min:3','max:35'],
        ],
        [
            'name.required' => 'Kolom nama tidak boleh kosong.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.min' => 'Panjang nama tidak boleh kurang dari 1 karakter.',
            'name.max' => 'Panjang nama tidak boleh melebihi 150 karakter.',
            'gender.required' => 'Pilih jenis kelamin.',
            'gender.not_in' => 'Pilih jenis kelamin yang valid.',
            'place_of_birth.required' => 'Kolom tempat lahir tidak boleh kosong.',
            'date_of_birth.required' => 'Kolom tanggal lahir tidak boleh kosong.',
            'religion.required' => 'Kolom agama tidak boleh kosong.',
            'school.required' => 'Kolom sekolah tidak boleh kosong.',
            'major.required' => 'Kolom jurusan tidak boleh kosong.',
            'major.min' => 'Panjang jurusan tidak boleh kurang dari 1 karakter.',
            'major.max' => 'Panjang jurusan tidak boleh melebihi 100 karakter.',
            'class.required' => 'Kolom kelas tidak boleh kosong.',
            'class.min' => 'Panjang kelas tidak boleh kurang dari 1 karakter.',
            'class.max' => 'Panjang kelas tidak boleh melebihi 100 karakter.',
            'year.required' => 'Kolom tahun lulus tidak boleh kosong.',
            'year.min' => 'Panjang tahun lulus tidak boleh kurang dari 4 karakter.',
            'year.max' => 'Panjang tahun lulus tidak boleh melebihi 4 karakter.',
            'income_parent.required' => 'Kolom pendapatan orang tua tidak boleh kosong.',
            'social_media.required' => 'Kolom username social media tidak boleh kosong.',
            'social_media.min' => 'Panjang username social media tidak boleh kurang dari 3 karakter.',
            'social_media.max' => 'Panjang username social media tidak boleh melebihi 35 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['validate' => true, 'message' => $validator->errors()], 422);
        }

        $user = User::where('identity', $identity)->first();
        $applicant = Applicant::where('identity', $identity)->first();

        $rt_digit = strlen($request->rt) < 2 ? '0' . $request->rt : $request->rt;
        $rw_digit = strlen($request->rw) < 2 ? '0' . $request->rw : $request->rw;

        $place = $request->place !== null ? ucwords(strtolower($request->place)) . ', ' : null;
        $rt = $request->rt !== null ? 'RT. ' . $rt_digit . ' ' : null;
        $rw = $request->rw !== null ? 'RW. ' . $rw_digit . ', ' : null;
        $kel = $request->village !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->village)) . ', ' : null;
        $kec = $request->district !== null ? 'Kecamatan ' . ucwords(strtolower($request->district)) . ', ' : null;
        $reg = $request->regency !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->regency)) . ', ' : null;
        $prov = $request->province !== null ? 'Provinsi ' . ucwords(strtolower($request->province)) . ', ' : null;
        $postal = $request->postal_code !== null ? 'Kode Pos ' . $request->postal_code : null;

        $address_applicant = $place . $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $schoolCheck = School::where('id', $request->school)->first();
        $schoolNameCheck = School::where('name', $request->school)->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            if ($schoolNameCheck) {
                $school = $schoolNameCheck->id;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->input('school')),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $schoolCreate = School::create($dataSchool);
                $school = $schoolCreate->id;
            }
        }

        if($address_applicant){
            if($request->address == $address_applicant){
                $address_data = $request->address;
            } else {
                $address_data = $address_applicant;
            }
        } else {
            $address_data = $applicant->address;
        }

        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'religion' => $request->religion,
            'school' => $school,
            'major' => $request->major,
            'class' => $request->class,
            'year' => $request->year,
            'income_parent' => $request->income_parent,
            'social_media' => $request->social_media,
            'address' => $address_data,
        ];

        $data_user = [
            'name' => $request->name,
            'gender' => $request->gender,
        ];

        $applicant->update($data);
        $user->update($data_user);

        return response()->json([
            'message' => 'Data pribadi berhasil diperbaharui!',

        ]);
    }

    public function update_prodi(Request $request, $identity){
        $validator = Validator::make($request->all(), [
            'program' => ['required'],
            'program_second' => ['required'],
        ],
        [
            'program.required' => 'Kolom program studi 1 tidak boleh kosong.',
            'program_second.required' => 'Kolom program studi 2 tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['validate' => true, 'message' => $validator->errors()], 422);
        }

        $applicant = Applicant::where('identity', $identity)->first();


        $data = [
            'program' => $request->program,
            'program_second' => $request->program_second,
            'programtype_id' => 1
        ];

        $applicant->update($data);

        return response()->json([
            'message' => 'Data program studi berhasil diperbaharui!',

        ]);
    }

    public function update_family(Request $request, $identity){
        $validator = Validator::make($request->all(), [
            'father_name' => ['required', 'min:1', 'max:150'],
            'father_job' => ['required', 'min:1', 'max:150'],
            'father_phone' => ['required', 'min:1', 'max:150'],
            'father_place_of_birth' => ['required'],
            'father_date_of_birth' => ['required'],
            'father_education' => ['required', 'min:1', 'max:150'],
            'mother_name' => ['required', 'min:1', 'max:150'],
            'mother_job' => ['required', 'min:1', 'max:150'],
            'mother_phone' => ['required', 'min:1', 'max:150'],
            'mother_place_of_birth' => ['required'],
            'mother_date_of_birth' => ['required'],
        ],
        [
            'father_name.required' => 'Kolom nama ayah tidak boleh kosong.',
            'father_name.min' => 'Panjang nama ayah tidak boleh kurang dari 1 karakter.',
            'father_name.max' => 'Panjang nama ayah tidak boleh melebihi 150 karakter.',
            'father_job.required' => 'Kolom pekerjaan ayah tidak boleh kosong.',
            'father_job.min' => 'Panjang pekerjaan ayah tidak boleh kurang dari 1 karakter.',
            'father_job.max' => 'Panjang pekerjaan ayah tidak boleh melebihi 150 karakter.',
            'father_phone.required' => 'Kolom telpon ayah tidak boleh kosong.',
            'father_phone.min' => 'Panjang telpon ayah tidak boleh kurang dari 1 karakter.',
            'father_phone.max' => 'Panjang telpon ayah tidak boleh melebihi 150 karakter.',
            'father_place_of_birth.required' => 'Kolom tempat lahir ayah tidak boleh kosong.',
            'father_date_of_birth.required' => 'Kolom tempat lahir ayah tidak boleh kosong.',
            'father_education.required' => 'Kolom pendidikan terakhir ayah tidak boleh kosong.',
            'father_education.min' => 'Panjang pendidikan terakhir ayah tidak boleh kurang dari 1 karakter.',
            'father_education.max' => 'Panjang pendidikan terakhir ayah tidak boleh melebihi 150 karakter.',
            'mother_name.required' => 'Kolom nama ibu tidak boleh kosong.',
            'mother_name.min' => 'Panjang nama ibu tidak boleh kurang dari 1 karakter.',
            'mother_name.max' => 'Panjang nama ibu tidak boleh melebihi 150 karakter.',
            'mother_job.required' => 'Kolom pekerjaan ibu tidak boleh kosong.',
            'mother_job.min' => 'Panjang pekerjaan ibu tidak boleh kurang dari 1 karakter.',
            'mother_job.max' => 'Panjang pekerjaan ibu tidak boleh melebihi 150 karakter.',
            'mother_phone.required' => 'Kolom telpon ibu tidak boleh kosong.',
            'mother_phone.min' => 'Panjang telpon ibu tidak boleh kurang dari 1 karakter.',
            'mother_phone.max' => 'Panjang telpon ibu tidak boleh melebihi 150 karakter.',
            'mother_place_of_birth.required' => 'Kolom tempat lahir ibu tidak boleh kosong.',
            'mother_date_of_birth.required' => 'Kolom tempat lahir ibu tidak boleh kosong.',
            'mother_education.required' => 'Kolom pendidikan terakhir ibu tidak boleh kosong.',
            'mother_education.min' => 'Panjang pendidikan terakhir ibu tidak boleh kurang dari 1 karakter.',
            'mother_education.max' => 'Panjang pendidikan terakhir ibu tidak boleh melebihi 150 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['validate' => true, 'message' => $validator->errors()], 422);
        }

        $father_rt_digit = strlen($request->father_rt) < 2 ? '0' . $request->father_rt : $request->father_rt;
        $father_rw_digit = strlen($request->father_rw) < 2 ? '0' . $request->father_rw : $request->father_rw;

        $father_place = $request->father_place !== null ? ucwords(strtolower($request->father_place)) . ', ' : null;
        $father_rt = $request->father_rt !== null ? 'RT. ' . $father_rt_digit . ' ' : null;
        $father_rw = $request->father_rw !== null ? 'RW. ' . $father_rw_digit . ', ' : null;
        $father_kel = $request->father_village !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->father_village)) . ', ' : null;
        $father_kec = $request->father_district !== null ? 'Kecamatan ' . ucwords(strtolower($request->father_district)) . ', ' : null;
        $father_reg = $request->father_regency !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->father_regency)) . ', ' : null;
        $father_prov = $request->father_province !== null ? 'Provinsi ' . ucwords(strtolower($request->father_province)) . ', ' : null;
        $father_postal = $request->father_postal_code !== null ? 'Kode Pos ' . $request->father_postal_code : null;

        $father_address = $father_place . $father_rt . $father_rw . $father_kel . $father_kec . $father_reg . $father_prov . $father_postal;

        $mother_rt_digit = strlen($request->mother_rt) < 2 ? '0' . $request->mother_rt : $request->mother_rt;
        $mother_rw_digit = strlen($request->mother_rw) < 2 ? '0' . $request->mother_rw : $request->mother_rw;

        $mother_place = $request->mother_place !== null ? ucwords(strtolower($request->mother_place)) . ', ' : null;
        $mother_rt = $request->mother_rt !== null ? 'RT. ' . $mother_rt_digit . ' ' : null;
        $mother_rw = $request->mother_rw !== null ? 'RW. ' . $mother_rw_digit . ', ' : null;
        $mother_kel = $request->mother_village !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->mother_village)) . ', ' : null;
        $mother_kec = $request->mother_district !== null ? 'Kecamatan ' . ucwords(strtolower($request->mother_district)) . ', ' : null;
        $mother_reg = $request->mother_regency !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->mother_regency)) . ', ' : null;
        $mother_prov = $request->mother_province !== null ? 'Provinsi ' . ucwords(strtolower($request->mother_province)) . ', ' : null;
        $mother_postal = $request->mother_postal_code !== null ? 'Kode Pos ' . $request->mother_postal_code : null;

        $mother_address = $mother_place . $mother_rt . $mother_rw . $mother_kel . $mother_kec . $mother_reg . $mother_prov . $mother_postal;

        $father = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 0])->first();

        if($father_address){
            if($request->father_address == $father_address){
                $father_data_address = $request->father_address;
            } else {
                $father_data_address = $father_address;
            }
        } else {
            $father_data_address = $father->address;
        }

        if($mother_address){
            if($request->mother_address == $mother_address){
                $mother_data_address = $request->mother_address;
            } else {
                $mother_data_address = $mother_address;
            }
        } else {
            $mother_data_address = $mother->address;
        }

        $data_father_update = [
            'name' => $request->father_name,
            'job' => $request->father_job,
            'phone' => $request->father_phone,
            'place_of_birth' => $request->father_place_of_birth,
            'date_of_birth' => $request->father_date_of_birth,
            'education' => $request->father_education,
            'address' => $father_data_address,
        ];

        $data_mother_update = [
            'name' => $request->mother_name,
            'job' => $request->mother_job,
            'phone' => $request->mother_phone,
            'place_of_birth' => $request->mother_place_of_birth,
            'date_of_birth' => $request->mother_date_of_birth,
            'education' => $request->mother_education,
            'address' => $mother_data_address,
        ];

        $father->update($data_father_update);
        $mother->update($data_mother_update);

        return response()->json([
            'message' => 'Data orang tua berhasil diperbaharui!',
        ]);
    }
}
