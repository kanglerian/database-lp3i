<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
        $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');

        $users = User::where(['status' => '1', 'role' => 'P'])->get();

        if ($response->successful()) {
            $programs = $response->json();
        }

        return view('pages.database.create')->with([
            'programs' => $programs,
            'users' => $users,
        ]);
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
            $data = [
                'identity' => mt_rand(1,1000000000),
                'name' => $request->input('name'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
                'school' => $request->input('school'),
                'year' => $request->input('year'),
                'source' => $request->input('source'),
                'status' => $request->input('status'),
                'identity_user' => $request->input('identity_user'),
                'program' => $request->input('program'),
                'isread' => '0',
            ];
            Applicant::create($data);
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
        $account = User::where('email', $applicant->email)->count();

        if ($response->successful()) {
            $programs = $response->json();
        }
        $applicant = Applicant::findOrFail($id);
        return view('pages.database.edit')->with([
            'applicant' => $applicant,
            'programs' => $programs,
            'presenters' => $presenters,
            'account' => $account
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

        if($user_detail !== null){
            $data_user = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
            ];
            $user = User::findOrFail($user_detail->id);
            $user->update($data_user);
        };

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'religion' => $request->input('religion'),
            'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
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
            'mother_place_of_birth' => $request->input('mother_place_of_birth'),
            'mother_date_of_birth' => $request->input('mother_date_of_birth'),
            'mother_education' => $request->input('mother_education'),
            'mother_phone' => $request->input('mother_phone'),
            'mother_address' => $request->input('mother_address'),
            'mother_job' => $request->input('mother_job'),
            'father_name' => $request->input('father_name'),
            'father_place_of_birth' => $request->input('father_place_of_birth'),
            'father_date_of_birth' => $request->input('father_date_of_birth'),
            'father_education' => $request->input('father_education'),
            'father_phone' => $request->input('father_phone'),
            'father_address' => $request->input('father_address'),
            'father_job' => $request->input('father_job'),
            'source' => $request->input('source'),
            'note' => $request->input('note'),
            'status' => $request->input('status'),
            'identity_user' => $request->input('identity_user'),
            'program' => $request->input('program'),
        ];
        $applicant->update($data);
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
        $applicant->delete();

        return session()->flash('message', 'Data aplikan berhasil dihapus!');
    }
}
