<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\SourceSetting;
use App\Models\ApplicantDatabase;
use App\Models\User;
use Illuminate\Database\QueryException;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = SourceSetting::all();
        $databases = ApplicantDatabase::all();
        if (Auth::user()->role == 'A') {
            $total = Applicant::count();
        } else {
            $total = Applicant::where('identity_user', Auth::user()->identity)->count();
        }
        return view('pages.database.index')->with([
            'total' => $total,
            'databases' => $databases,
            'sources' => $sources,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_all($type = 'all')
    {
        if (Auth::check() && Auth::user()->role == 'P') {
            if ($type == 'all') {
                $applicants = Applicant::with('sourceSetting')
                    ->where('identity_user', Auth::user()->identity)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $applicants = Applicant::with('sourceSetting')
                    ->where(['identity_user' => Auth::user()->identity, 'source' => $type])
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return response()
                ->json([
                    'applicants' => $applicants,
                ])
                ->header('Content-Type', 'application/json');
        } elseif (Auth::check() && Auth::user()->role == 'A') {
            if ($type == 'all') {
                $applicants = Applicant::with('sourceSetting')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $applicants = Applicant::with('sourceSetting')
                    ->where('source', $type)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return response()
                ->json([
                    'applicants' => $applicants,
                ])
                ->header('Content-Type', 'application/json');
        } else {
            if ($type == 'all') {
                $applicants = Applicant::with('sourceSetting')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $applicants = Applicant::with('sourceSetting')
                    ->where('source', $type)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return response()
                ->json([
                    'applicants' => $applicants,
                ])
                ->header('Content-Type', 'application/json');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');
            $users = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();

            if ($response->successful()) {
                $programs = $response->json();
            } else {
                $programs = null;
            }

            return view('pages.database.create')->with([
                'programs' => $programs,
                'sources' => $sources,
                'users' => $users,
            ]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'source' => ['required', 'string', 'not_in:0'],
                'status' => ['required', 'string', 'not_in:0'],
                'identity_user' => ['string', 'not_in:Pilih presenter'],
                'program' => ['string', 'not_in:Pilih program'],
                'isread' => ['string'],
            ]);

            $numbers_unique = mt_rand(1, 1000000000);
            $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
            $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
            $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
            $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
            $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
            $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
            $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;

            $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

            $data_applicant = [
                'identity' => $numbers_unique,
                'name' => $request->input('name'),
                'gender' => $request->input('gender'),
                'place_of_birth' => $request->input('place_of_birth'),
                'date_of_birth' => $request->input('date_of_birth'),
                'religion' => $request->input('religion'),
                'address' => $address_applicant,
                'email' => $request->input('email'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
                'education' => $request->input('education'),
                'major' => $request->input('major'),
                'year' => $request->input('year'),
                'school' => $request->input('school'),
                'class' => $request->input('class'),
                'source' => $request->input('source'),
                'status' => $request->input('status'),
                'program' => $request->input('program'),
                'identity_user' => $request->input('identity_user'),
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

            $check = [
                'rt' => $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null,
                'rw' => $request->input('rw'),
                'postal_code' => $request->input('postal_code'),
                'villages' => $request->input('villages'),
                'districts' => $request->input('districts'),
                'regencies' => $request->input('regencies'),
                'provincies' => $request->input('provincies'),
            ];

            Applicant::create($data_applicant);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            return back()->with('message', 'Data aplikan berhasil ditambahkan!');
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                $errorMessage = 'Terjadi duplikat data.';
                return back()->with('error', $errorMessage);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');

        $presenters = User::where(['status' => '1', 'role' => 'P'])->get();
        $applicant = Applicant::findOrFail($id);
        $sources = SourceSetting::all();
        $account = User::where('email', $applicant->email)->count();
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

        if ($response->successful()) {
            $programs = $response->json();
        } else {
            $programs = null;
        }

        $applicant = Applicant::findOrFail($id);
        return view('pages.database.edit')->with([
            'applicant' => $applicant,
            'programs' => $programs,
            'presenters' => $presenters,
            'account' => $account,
            'father' => $father,
            'mother' => $mother,
            'sources' => $sources,
        ]);
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
        $applicant = Applicant::findOrFail($id);
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        $user_detail = User::where('identity', $applicant->identity)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'source' => ['required', 'string'],
            'status' => ['required', 'string'],
            'identity_user' => ['string', 'not_in:Pilih presenter'],
            'program' => ['string', 'not_in:Pilih program'],
            'isread' => ['string'],
        ]);

        if ($user_detail !== null) {
            $data_user = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            ];
            $user = User::findOrFail($user_detail->id);
            $user->update($data_user);
        }

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;

        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $data = [
            'program' => $request->input('program'),
            'identity_user' => $request->input('identity_user'),
            'source' => $request->input('source'),
            'status' => $request->input('status'),
            'email' => $request->input('email'),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            'note' => $request->input('note'),
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
            'address' => $request->input('address') == null ? $address_applicant : $request->input('address'),
        ];

        $father_rt = $request->input('father_rt') !== null ? 'RT. ' . $request->input('father_rt') . ' ' : null;
        $father_rw = $request->input('father_rw') !== null ? 'RW. ' . $request->input('father_rw') . ' ' : null;
        $father_kel = $request->input('father_villages') !== null ? 'Desa/Kel. ' . $request->input('father_villages') . ' ' : null;
        $father_kec = $request->input('father_districts') !== null ? 'Kec. ' . $request->input('father_districts') . ' ' : null;
        $father_reg = $request->input('father_regencies') !== null ? 'Kota/Kab. ' . $request->input('father_regencies') . ' ' : null;
        $father_prov = $request->input('father_provinces') !== null ? 'Provinsi ' . $request->input('father_provinces') . ' ' : null;
        $father_postal = $request->input('father_postal_code') !== null ? 'Kode Pos ' . $request->input('father_postal_code') : null;

        $address_father = $father_rt . $father_rw . $father_kel . $father_kec . $father_reg . $father_prov . $father_postal;

        $data_father = [
            'name' => $request->input('father_name'),
            'job' => $request->input('father_job'),
            'place_of_birth' => $request->input('father_place_of_birth'),
            'date_of_birth' => $request->input('father_date_of_birth'),
            'education' => $request->input('father_education'),
            'phone' => strpos($request->input('father_phone'), '0') === 0 ? '62' . substr($request->input('father_phone'), 1) : $request->input('father_phone'),
            'address' => $request->input('father_address') == null ? $address_father : $request->input('father_address'),
        ];

        $mother_rt = $request->input('mother_rt') !== null ? 'RT. ' . $request->input('mother_rt') . ' ' : null;
        $mother_rw = $request->input('mother_rw') !== null ? 'RW. ' . $request->input('mother_rw') . ' ' : null;
        $mother_kel = $request->input('mother_villages') !== null ? 'Desa/Kel. ' . $request->input('mother_villages') . ' ' : null;
        $mother_kec = $request->input('mother_districts') !== null ? 'Kec. ' . $request->input('mother_districts') . ' ' : null;
        $mother_reg = $request->input('mother_regencies') !== null ? 'Kota/Kab. ' . $request->input('mother_regencies') . ' ' : null;
        $mother_prov = $request->input('mother_provinces') !== null ? 'Provinsi ' . $request->input('mother_provinces') . ' ' : null;
        $mother_postal = $request->input('mother_postal_code') !== null ? 'Kode Pos ' . $request->input('mother_postal_code') : null;

        $address_father = $mother_rt . $mother_rw . $mother_kel . $mother_kec . $mother_reg . $mother_prov . $mother_postal;

        $data_mother = [
            'name' => $request->input('mother_name'),
            'job' => $request->input('mother_job'),
            'place_of_birth' => $request->input('mother_place_of_birth'),
            'date_of_birth' => $request->input('mother_date_of_birth'),
            'education' => $request->input('mother_education'),
            'phone' => strpos($request->input('mother_phone'), '0') === 0 ? '62' . substr($request->input('mother_phone'), 1) : $request->input('mother_phone'),
            'address' => $request->input('mother_address') == null ? $address_father : $request->input('mother_address'),
        ];

        $applicant->update($data);
        $father->update($data_father);
        $mother->update($data_mother);

        return back()->with('message', 'Data aplikan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        $family = ApplicantFamily::where('identity_user', $applicant->identity);
        $user = User::where('identity', $applicant->identity);
        $family->delete();
        $applicant->delete();
        $user->delete();
        return session()->flash('message', 'Data aplikan berhasil dihapus!');
    }
}
