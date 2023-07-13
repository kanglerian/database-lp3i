<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
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
        return view('pages.database.index');
    }

    public function get_all()
    {
        if (Auth::check() && Auth::user()->role == 'P') {
            $applicants = Applicant::where('identity_user', Auth::user()->identity)->get();
            return response()
                ->json([
                    'applicants' => $applicants,
                ])
                ->header('Content-Type', 'application/json');
        } elseif (Auth::check() && Auth::user()->role == 'A') {
            $applicants = Applicant::all();
            return response()
                ->json([
                    'applicants' => $applicants,
                ])
                ->header('Content-Type', 'application/json');
        } else {
            $applicants = Applicant::all();
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

            if ($response->successful()) {
                $programs = $response->json();
            } else {
                $programs = null;
            }

            return view('pages.database.create')->with([
                'programs' => $programs,
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
        try {
            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');

            $presenters = User::where(['status' => '1', 'role' => 'P'])->get();
            $applicant = Applicant::findOrFail($id);
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
                'mother' => $mother
            ]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
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
        try {
            $applicant = Applicant::findOrFail($id);
            $user_detail = User::where('identity', $applicant->identity)->first();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'gender' => ['required'],
                'source' => ['required', 'string'],
                'status' => ['required', 'string'],
                'identity_user' => ['string'],
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
            $applicant->update($data);
            return back()->with('message', 'Data aplikan berhasil diubah!');
            
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            $family = ApplicantFamily::where('identity_user', $applicant->identity);
            $family->delete();
            $applicant->delete();
            return session()->flash('message', 'Data aplikan berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
