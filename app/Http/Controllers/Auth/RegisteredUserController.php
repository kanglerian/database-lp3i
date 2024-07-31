<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantStatus;
use App\Models\ProgramType;
use App\Models\School;
use App\Models\SourceSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');
            $users = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::where('status', 1)->get();
            $schools = School::all();

            if ($response->successful()) {
                $programs = $response->json();
            } else {
                $programs = null;
            }

            return view('auth.register')->with([
                'programs' => $programs,
                'statuses' => $statuses,
                'programtypes' => $programtypes,
                'sources' => $sources,
                'users' => $users,
                'schools' => $schools,
            ]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }

    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'programtype_id' => ['required', 'not_in:0'],
            'program' => ['required', 'string', 'not_in:0'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'not_in:null'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required'],
            'religion' => ['required'],
            'major' => ['required'],
            'year' => ['required', 'min:4','max:4'],
            'school' => ['required', 'max:100', 'not_in:Pilih Sekolah'],

            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15'
            ],

            'password' => ['required', 'confirmed'],
        ], [
            'programtype_id.required' => 'Oopss, sepertinya kamu lupa memilih Program Kuliah, yuk isi!',
            'programtype_id.not_in' => 'Ayo pilih Program Kuliah yang valid, pasti bisa!',
            'program.required' => 'Program Studi wajib diisi, nih!',
            'program.not_in' => 'Jangan lupa pilih Program Studi yang valid, ya!',
            'name.required' => 'Hei, Nama Lengkap jangan sampai kosong ya!',
            'gender.required' => 'Jenis Kelamin juga penting, lho. Isi dong!',
            'gender.not_in' => 'Jenis Kelamin juga penting, lho. Isi dong!',
            'place_of_birth.required' => 'Tempat Lahir jangan terlupakan ya!',
            'date_of_birth.required' => 'Tanggal Lahir harus diisi, nih!',
            'religion.required' => 'Agama jangan lupa diisi, ya!',
            'major.required' => 'Jurusan wajib diisi, pasti pilihan yang bagus!',
            'year.required' => 'Tahun lulus jangan sampai kosong, ya!',
            'year.min' => 'Tahun harus memiliki setidaknya 4 digit, pastikan benar ya!',
            'school.max' => 'Sekolah tidak boleh lebih dari 100 karakter, pastikan benar ya!',
            'school.required' => 'Sekolah juga jangan terlupakan, lho!',
            'school.not_in' => 'Ayo pilih Sekolah yang valid, pasti oke!',
            'email.required' => 'Email jangan sampai kosong, ya!',
            'email.email' => 'Format email sepertinya kurang benar, cek lagi ya!',
            'phone.required' => 'Nomor Telepon jangan sampai kosong, ya!',
            'phone.string' => 'Nomor Telepon harus berupa string, nih!',
            'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
            'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
            'password.required' => 'Password jangan sampai kosong, ya!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai, cek lagi ya!',
        ]);

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;

        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $schoolCheck = School::where('id', $request->input('school'))->first();
        $schoolNameCheck = School::where('name', $request->input('school'))->first();

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

        $check_email_applicant = Applicant::where('email', $request->input('email'))->first();
        $check_phone_applicant = Applicant::where('phone', $request->input('phone'))->first();

        $check_email_user = User::where('email', $request->input('email'))->first();

        $identity_val = Str::uuid();

        if ($check_email_applicant) {
            if ($check_email_user) {
                return back()->with('error', 'Akun sudah ditambahkan. Jika anda lupa Email dan Kata Sandi silahkan hubungi Panitia PMB melalui tombol Whatsapp.');
            } else {
                if ($check_phone_applicant) {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'gender' => $check_email_applicant->gender,
                        'email' => $check_email_applicant->email,
                        'phone' => $check_phone_applicant->phone,
                        'password' => Hash::make($request->input('password')),
                        'role' => 'S',
                        'status' => '1',
                    ];
                    $user = User::create($data_user);
                    Auth::login($user);
                } else {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'gender' => $check_email_applicant->gender,
                        'email' => $check_email_applicant->email,
                        'phone' => $request->input('phone'),
                        'password' => Hash::make($request->input('password')),
                        'role' => 'S',
                        'status' => '1',
                    ];
                    $user = User::create($data_user);
                    Auth::login($user);
                }
            }
        } else {
            if ($check_phone_applicant) {
                $data_applicant = [
                    'identity' => $check_phone_applicant->identity,
                    'programtype_id' => $request->input('programtype_id'),
                    'program' => $request->input('program'),
                    'program_second' => $request->input('program'),
                    'name' => $check_phone_applicant->name,
                    'gender' => $request->input('gender'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'religion' => $request->input('religion'),
                    'major' => $request->input('major'),
                    'year' => $request->input('year'),
                    'school' => $school,
                    'class' => $request->input('class'),
                    'address' => $address_applicant,
                    'email' => $request->input('email'),
                    'source_daftar_id' => $check_phone_applicant->source_daftar_id ?? 8,
                    'status_id' => 2,
                    'come' => 0,
                    'isread' => '0',
                ];

                $data_user = [
                    'identity' => $check_phone_applicant->identity,
                    'name' => $check_phone_applicant->name,
                    'gender' => $check_phone_applicant->gender,
                    'email' => $request->input('email'),
                    'phone' => $check_phone_applicant->phone,
                    'password' => Hash::make($request->input('password')),
                    'role' => 'S',
                    'status' => '1',
                ];

                $user = User::create($data_user);
                $check_phone_applicant->update($data_applicant);
                Auth::login($user);
            } else {
                $data_applicant = [
                    'identity' => $identity_val,
                    'programtype_id' => $request->input('programtype_id'),
                    'program' => $request->input('program'),
                    'program_second' => $request->input('program'),
                    'name' => ucwords(strtolower($request->input('name'))),
                    'gender' => $request->input('gender'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'religion' => $request->input('religion'),
                    'major' => $request->input('major'),
                    'year' => $request->input('year'),
                    'school' => $school,
                    'class' => $request->input('class'),
                    'address' => $address_applicant,
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'pmb' => $request->input('pmb'),
                    'identity_user' => '6281313608558',
                    'source_id' => 8,
                    'source_daftar_id' => 8,
                    'status_id' => 4,
                    'come' => 0,
                    'isread' => '0',
                ];

                $data_user = [
                    'identity' => $identity_val,
                    'name' => $request->input('name'),
                    'gender' => $request->input('gender'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'password' => Hash::make($request->input('password')),
                    'role' => 'S',
                    'status' => '1',
                ];

                $data_father = [
                    'identity_user' => $identity_val,
                    'gender' => 1,
                ];
                $data_mother = [
                    'identity_user' => $identity_val,
                    'gender' => 0,
                ];

                $user = User::create($data_user);
                Applicant::create($data_applicant);
                ApplicantFamily::create($data_father);
                ApplicantFamily::create($data_mother);
                Auth::login($user);
            }
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
