<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantStatus;
use App\Models\ProgramType;
use App\Models\School;
use App\Models\SourceSetting;
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
            $programtypes = ProgramType::all();
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
            'education' => ['required'],
            'major' => ['required'],
            'year' => ['required'],
            'school' => ['required', 'not_in:Pilih Sekolah'],

            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
            ],

            'password' => ['required', 'confirmed'],
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
            if($schoolNameCheck){
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

        $min = 1;
        $max = 100000000000000;
        $random_number = mt_rand($min, $max);
        $numbers_unique = $random_number / abs($min);

        if ($check_email_applicant) {
            if ($check_email_user) {
            return back()->with('error', 'Akun sudah ditambahkan. Jika anda lupa Email dan Kata Sandi silahkan hubungi Panitia PMB melalui tombol Whatsapp.');
            } else {
                if ($check_phone_applicant) {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $check_phone_applicant->phone,
                        'password' => Hash::make($request->input('password')),
                        'role' => 'S',
                        'status' => '0',
                    ];
                    $user = User::create($data_user);
                    Auth::login($user);
                } else {
                    $data_user = [
                        'identity' => $check_email_applicant->identity,
                        'name' => $check_email_applicant->name,
                        'email' => $check_email_applicant->email,
                        'phone' => $request->input('phone'),
                        'password' => Hash::make($request->input('password')),
                        'role' => 'S',
                        'status' => '0',
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
                    'name' => $check_phone_applicant->name,
                    'gender' => $request->input('gender'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'religion' => $request->input('religion'),
                    'education' => $request->input('education'),
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
                    'email' => $request->input('email'),
                    'phone' => $check_phone_applicant->phone,
                    'password' => Hash::make($request->input('password')),
                    'role' => 'S',
                    'status' => '0',
                ];

                $user = User::create($data_user);
                $check_phone_applicant->update($data_applicant);
                Auth::login($user);
            } else {
                $data_applicant = [
                    'identity' => $numbers_unique,
                    'programtype_id' => $request->input('programtype_id'),
                    'program' => $request->input('program'),
                    'name' => ucwords(strtolower($request->input('name'))),
                    'gender' => $request->input('gender'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'religion' => $request->input('religion'),
                    'education' => $request->input('education'),
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
                    'identity' => $numbers_unique,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'password' => Hash::make($request->input('password')),
                    'role' => 'S',
                    'status' => '0',
                ];

                $data_father = [
                    'identity_user' => $numbers_unique,
                    'gender' => 1,
                ];
                $data_mother = [
                    'identity_user' => $numbers_unique,
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
