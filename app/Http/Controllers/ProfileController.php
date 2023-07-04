<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\Applicant;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'phone' => ['string', 'unique:users', 'max:15'],
        ]);

        $data = [
            'identity' => $request->input('identity'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make(strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone')),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            'role' => 'S',
            'status' => 1,
        ];
        User::create($data);
        return back()->with('message', 'Akun berhasil ditambahkan!');
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
        $user = User::findOrFail($id);
        $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');
        $applicant = Applicant::where('identity', $user->identity)->first();
        $presenters = User::where(['status' => '1', 'role' => 'P'])->get();

        if ($response->successful()) {
            $programs = $response->json();
        }

        return view('pages.profile.edit')->with([
            'user' => $user,
            'applicant' => $applicant,
            'programs' => $programs,
            'presenters' => $presenters,
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
        $user = User::findOrFail($id);
        $user_detail = Applicant::where('identity', $user->identity)->first();
        $applicant = Applicant::findOrFail($user_detail->id);
        $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'year' => ['string', 'digits:4'],
            'gender' => ['required', 'not_in:Pilih gender'],
        ]);
        $data = [
            'education' => $request->input('education'),
            'school' => $request->input('school'),
            'major' => $request->input('major'),
            'class' => $request->input('class'),
            'year' => $request->input('year'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'mother_name' => $request->input('mother_name'),
            'mother_job' => $request->input('mother_job'),
            'father_name' => $request->input('father_name'),
            'father_job' => $request->input('father_job'),
            'parent_phone' => strpos($request->input('parent_phone'), '0') === 0 ? '62' . substr($request->input('parent_phone'), 1) : $request->input('parent_phone'),
        ];
        $applicant->update($data);
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
        //
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
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
        ];

        if($user_detail !== null){
            $applicant = Applicant::findOrFail($user_detail->id);
            $applicant->update($data);
        };

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
}
