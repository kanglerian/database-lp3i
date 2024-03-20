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
use Illuminate\Http\JsonResponse;

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
        $schools_by_region = School::select('region')->groupBy('region')->get();
        $slepets = School::where(['region' => 'TIDAK DIKETAHUI'])
            ->orWhereNull('name')
            ->orWhereNull('region')
            ->orWhereNull('type')
            ->orWhereNull('status')
            ->count();
        return view('pages.schools.index')->with([
            'total' => $total,
            'schools_by_region' => $schools_by_region,
            'slepets' => $slepets
        ]);
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
        return view('pages.schools.show')->with([
            'school' => $school,
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
        $request->validate([
            'name' => ['required'],
            'type' => ['required', 'not_in:Pilih'],
            'status' => ['required', 'not_in:Pilih'],
            'region' => ['required', 'not_in:Pilih'],
        ], [
            'name.required' => 'Kolom nama sekolah tidak boleh kosong.',
            'type.required' => 'Kolom tipe sekolah tidak boleh kosong.',
            'type.not_in' => 'Pilih tipe sekolah tidak valid.',
            'status.required' => 'Kolom status sekolah tidak boleh kosong.',
            'status.not_in' => 'Pilih status sekolah tidak valid.',
            'region.required' => 'Kolom wilayah sekolah tidak boleh kosong.',
            'region.not_in' => 'Pilih wilayah sekolah tidak valid.',
        ]);

        $data = [
            'name' => strtoupper($request->input('name')),
            'type' => strtoupper($request->input('type')),
            'status' => strtoupper($request->input('status')),
            'region' => strtoupper($request->input('region')),
        ];

        $school = School::findOrFail($id);
        $school->update($data);

        return back()->with('message', 'Data sekolah berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $applicants = Applicant::where('school', $id)->count();
        if ($applicants > 0) {
            return response()->json([
                'message' =>
                    'Gagal menghapus data: Data tersebut masih digunakan di bagian lain dan tidak dapat dihapus.'
            ]);
        } else {
            $school->delete();
            return response()->json([
                'message' => 'Data sumber database berhasil dihapus!'
            ]);
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
