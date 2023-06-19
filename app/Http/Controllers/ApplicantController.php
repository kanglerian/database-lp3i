<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            $applicants = Applicant::where('nik_user', Auth::user()->nik)->get();
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
                'phone' => ['required', 'string', 'max:15', 'min:10'],
                'school' => ['required', 'string', 'max:255'],
                'year' => ['required', 'string', 'digits:4'],
                'source' => ['required', 'string', 'not_in:Pilih sumber'],
                'status' => ['required', 'string', 'not_in:Pilih status'],
                'nik_user' => ['string', 'not_in:Pilih presenter'],
                'program' => ['string', 'not_in:Pilih program'],
                'isread' => ['string'],
            ]);
            $data = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'school' => $request->input('school'),
                'year' => $request->input('year'),
                'source' => $request->input('source'),
                'source' => $request->input('source'),
                'status' => $request->input('status'),
                'nik_user' => $request->input('nik_user'),
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

        if ($response->successful()) {
            $programs = $response->json();
        }
        $applicant = Applicant::findOrFail($id);
        return view('pages.database.edit')->with([
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
        $applicant = Applicant::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'min:10'],
            'school' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'digits:4'],
            'source' => ['required', 'string', 'not_in:Pilih sumber'],
            'status' => ['required', 'string', 'not_in:Pilih status'],
            'nik_user' => ['string', 'not_in:Pilih presenter'],
            'program' => ['string', 'not_in:Pilih program'],
            'isread' => ['string'],
        ]);
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'school' => $request->input('school'),
            'year' => $request->input('year'),
            'source' => $request->input('source'),
            'source' => $request->input('source'),
            'status' => $request->input('status'),
            'nik_user' => $request->input('nik_user'),
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
