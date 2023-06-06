<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicants = Applicant::all();
        return view('pages.database.index')->with([
            'applicants' => $applicants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.database.create');
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
            'phone' => ['required', 'string', 'max:15', 'min:10'],
            'school' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'digits:4'],
            'source' => ['required', 'integer', 'max:10', 'not_in:Pilih sumber'],
            'status' => ['required', 'integer', 'max:10', 'not_in:Pilih status'],
            'presenter' => ['string', 'max:50', 'not_in:Pilih presenter'],
            'program' => ['string', 'max:255','not_in:Pilih program'],
            'isread' => ['boolean'],
        ]);
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'school' => $request->input('school'),
            'year' => $request->input('year'),
            'source' => $request->input('source'),
            'source' => $request->input('source'),
            'status' => $request->input('status'),
            'presenter' => $request->input('presenter'),
            'program' => $request->input('program'),
            'isread' => 0,
        ];
        Applicant::create($data);
        return back()->with('message', 'Data aplikan berhasil ditambahkan!');
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
        $applicant = Applicant::findOrFail($id);
        return view('pages.database.edit')->with([
            'applicant' => $applicant
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
            'source' => ['required', 'integer', 'max:10', 'not_in:Pilih sumber'],
            'status' => ['required', 'integer', 'max:10', 'not_in:Pilih status'],
            'presenter' => ['string', 'max:50', 'not_in:Pilih presenter'],
            'program' => ['string', 'max:255','not_in:Pilih program'],
            'isread' => ['boolean'],
        ]);
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'school' => $request->input('school'),
            'year' => $request->input('year'),
            'source' => $request->input('source'),
            'source' => $request->input('source'),
            'status' => $request->input('status'),
            'presenter' => $request->input('presenter'),
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
