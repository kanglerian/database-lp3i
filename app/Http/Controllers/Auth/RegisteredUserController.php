<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantStatus;
use App\Models\ProgramType;
use App\Models\School;
use App\Models\SourceSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Providers\RouteServiceProvider;
use App\Rules\PhoneValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

            'email' => ['required', 'email', 'max:255', 'unique:users', 'unique:applicants'],
            'phone' => [
                'required',
                'string',
                'unique:users',
                'unique:applicants'
            ],

            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $numbers_unique = mt_rand(1, 1000000000);

        $data = [
            'identity' => $numbers_unique,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'role' => 'S',
            'status' => '0',
        ];

        $data_applicant = [
            'identity' => $numbers_unique,
            'programtype_id' => $request->input('programtype_id'),
            'program' => $request->input('program'),
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'religion' => $request->input('religion'),
            'education' => $request->input('education'),
            'major' => $request->input('major'),
            'year' => $request->input('year'),
            'school' => $request->input('school'),
            'class' => $request->input('class'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'pmb' => $request->input('pmb'),
            'source_id' => 1,
            'status' => 3,
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

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}