<?php

namespace App\Http\Controllers;


use App\Imports\SchoolsImport;
use App\Models\Applicant;
use App\Models\Report\SchoolBySourceAll;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\SchoolByRegion;
use App\Models\School;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = School::count();
        $schools_by_region = SchoolByRegion::all();
        return view('pages.schools.index')->with([
            'total' => $total,
            'schools_by_region' => $schools_by_region
        ]);
    }

    public function get_all()
    {
        $schoolsQuery = SchoolBySourceAll::query();
        $regionCheck = request('regionCheck', 'all');

        if ($regionCheck !== 'all') {
            $schoolsQuery->where('wilayah', $regionCheck);
        }

        $schools = $schoolsQuery->get();

        return response()->json(['schools' => $schools]);
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
            'name' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);

        $data = [
            'name' => strtoupper($request->input('name')),
            'region' => strtoupper($request->input('region')),
        ];

        School::create($data);
        return back()->with('message', 'Data sekolah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = School::findOrFail($id);
        $details = Applicant::select('major', DB::raw('count(*) as total'))
        ->where('school', $id)
        ->groupBy('major')
        ->get();
        return view('pages.schools.show')->with([
            'school' => $school,
            'details' => $details,
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
        $school = School::findOrFail($id);
        return view('pages.schools.edit')->with([
            'school' => $school,
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
        //
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
            $school = School::findOrFail($id);
            $school->delete();
            return session()->flash('message', 'Data sekolah berhasil dihapus!');
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
    public function import(Request $request)
    {
        Excel::import(new SchoolsImport, $request->file('berkas'));

        return back()->with('message', 'Data sekolah berhasil diimport');
    }
}
