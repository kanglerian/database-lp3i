<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\User;
use App\Models\UserUpload;
use App\Models\FileUpload;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::count();
        $active = User::where('status', 1)->count();
        $deactive = User::where('status', 0)->count();
        return view('pages.user.index')->with([
            'users' => $users,
            'active' => $active,
            'deactive' => $deactive,
        ]);
    }

    public function get_all($role = null, $status = null)
    {
        $usersQuery = User::query();

        if(Auth::user()->role == 'P'){
            $usersQuery->where('role', 'S');
        }

        if ($role !== 'all' && $role !== null) {
            $usersQuery->where('role', $role);
        }

        if ($status !== 'all' && $status !== null) {
            $usersQuery->where('status', $status);
        }

        $users = $usersQuery->orderByDesc('created_at')->get();

        return response()
            ->json([
                'users' => $users,
            ])
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create');
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
                'email' => ['required', 'email', 'unique:users', 'max:255'],
                'phone' => ['string', 'unique:users', 'max:15'],
                'role' => ['string', 'not_in:Pilih peran'],
                'status' => ['string', 'not_in:Pilih status'],
                'password' => ['required', 'min:8', 'confirmed'],
            ]);

            $data = [
                'identity' => mt_rand(1, 1000000000),
                'name' => ucwords(strtolower($request->input('name'))),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'),
                'status' => $request->input('status'),
            ];
            User::create($data);
            return back()->with('message', 'Akun berhasil ditambahkan!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
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
        $user = User::findOrFail($id);
        $applicant = Applicant::where('identity', $user->identity)->firstOrFail();
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        $userupload = UserUpload::where('identity_user', $user->identity)->get();
        $data = [];
        foreach ($userupload as $upload) {
            $data[] = $upload->namefile;
        }
        $fileupload = FileUpload::whereNotIn('namefile', $data)->get();
        return view('pages.user.show')->with([
            'userupload' => $userupload,
            'fileupload' => $fileupload,
            'applicant' => $applicant,
            'user' => $user,
            'father' => $father,
            'mother' => $mother,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');
        $applicant = Applicant::where('identity', $user->identity)->first();
        $schools = School::all();

        if ($user->role == 'S') {
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        }

        $presenters = User::where(['status' => '1', 'role' => 'P'])->get();

        if ($response->successful()) {
            $programs = $response->json();
        } else {
            $programs = null;
        }

        if ($user->role == 'S') {
            $data = [
                'user' => $user,
                'applicant' => $applicant,
                'programs' => $programs,
                'presenters' => $presenters,
                'father' => $father,
                'mother' => $mother,
                'schools' => $schools,
            ];
        } else {
            $data = [
                'user' => $user,
            ];
        }

        return view('pages.profile.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user_detail = Applicant::where('identity', $user->identity)->first();
        $applicant = Applicant::findOrFail($user_detail->id);

        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

        $request->validate([
            'gender' => ['required', 'not_in:Pilih gender'],
        ]);

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;
        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'education' => $request->input('education'),
            'major' => $request->input('major'),
            'year' => $request->input('year'),
            'school' => $request->input('school'),
            'class' => $request->input('class'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'religion' => $request->input('religion'),
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
            'name' => ucwords($request->input('father_name')),
            'job' => $request->input('father_job'),
            'place_of_birth' => $request->input('father_place_of_birth'),
            'date_of_birth' => $request->input('father_date_of_birth'),
            'education' => $request->input('father_education'),
            'phone' => $request->input('father_phone'),
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
            'name' => ucwords($request->input('mother_name')),
            'job' => $request->input('mother_job'),
            'place_of_birth' => $request->input('mother_place_of_birth'),
            'date_of_birth' => $request->input('mother_date_of_birth'),
            'education' => $request->input('mother_education'),
            'phone' => $request->input('mother_phone'),
            'address' => $request->input('mother_address') == null ? $address_father : $request->input('mother_address'),
        ];

        $applicant->update($data);
        $father->update($data_father);
        $mother->update($data_mother);

        return back()->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = User::findOrFail($id);
        UserUpload::where('identity_user', $account->identity)->delete();
        $account->delete();
        return back()->with('message', 'Akun berhasil dihapus!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_account(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user_detail = Applicant::where('identity', $user->identity)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id), 'max:255'],
            'phone' => ['string', Rule::unique('users')->ignore($id), 'max:15'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        if ($user_detail !== null) {
            $applicant = Applicant::findOrFail($user_detail->id);
            $applicant->update($data);
        }

        $user->update($data);
        return back()->with('message', 'Data berhasil diubah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request, $id)
    {
        $account = User::findOrFail($id);
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $data = [
            'password' => Hash::make($request->input('password')),
        ];
        $account->update($data);
        return back()->with('message', 'Password berhasil diubah!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $applicant = Applicant::where('identity', $id)->firstOrFail();
        $user = User::where('identity', $id)->firstOrFail();
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        return view('pages.user.print')->with([
            'applicant' => $applicant,
            'father' => $father,
            'mother' => $mother,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'status' => ['string'],
        ]);
        $data = [
            'status' => $user->status == '0' ? '1' : '0',
        ];
        $user->update($data);
        return back()->with('message', 'Status berhasil diubah!');
    }
}
