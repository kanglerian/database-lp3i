<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Recommendation;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('register')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'P')->get();
        $schools = School::all();
        return view('pages.recommendation.index')->with([
            'users' => $users,
            'schools' => $schools
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools = School::all();
        return view('pages.recommendation.create')->with([
            'schools' => $schools
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
        $validator = Validator::make($request->all(), [
            'name.*' => 'required|string|max:255',
            'phone.*' => 'required|string|min:13|max:14',
            'school_id.*' => 'required|exists:schools,id',
            'class.*' => 'required|string|max:255',
            'year.*' => 'required|integer|min:1900',
        ], [
            'name.*.required' => 'Nama wajib diisi',
            'phone.*.required' => 'Nomor telepon wajib diisi',
            'phone.*.min' => 'Nomor telepon minimal 13 karakter',
            'phone.*.max' => 'Nomor telepon maksimal 14 karakter',
            'school_id.*.required' => 'Sekolah wajib dipilih',
            'school_id.*.exists' => 'Sekolah tidak valid',
            'class.*.required' => 'Kelas wajib diisi',
            'class.*.max' => 'Kelas maksimal 255 karakter',
            'year.*.required' => 'Tahun wajib diisi',
            'year.*.integer' => 'Tahun harus berupa angka',
            'year.*.min' => 'Tahun minimal 1900',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $names = $request->input('name');
        $phones = $request->input('phone');
        $schools = $request->input('school_id');
        $classes = $request->input('class');
        $years = $request->input('year');

        $data = [];
        for ($i = 0; $i < count($names); $i++) {
            array_push($data, [
                'identity_user' => Auth::user()->identity,
                'name' => $names[$i],
                'phone' => $phones[$i],
                'school_id' => $schools[$i],
                'class' => $classes[$i],
                'year' => $years[$i],
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);
        }
        Recommendation::insert($data);
        return back()->with('message', 'Data rekomendasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('identity', $id)->first();
        $applicant = Applicant::where('identity', $id)->first();
        $presenter = $applicant->identity_user;
        $schools = School::all();
        $recommendationQuery = Recommendation::query();

        $recommendationQuery->whereHas('applicant', function ($query) use ($presenter, $id) {
            $query->where('identity_user', $presenter);
            $query->where('identity', $id);
        });

        $recommendations = $recommendationQuery->get();
        return view('pages.recommendation.show')->with([
            'user' => $user,
            'recommendations' => $recommendations,
            'schools' => $schools,
            'applicant' => $applicant
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
        //
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
        $validator = Validator::make($request->all(), [
            'name.*' => 'required|string|max:255',
            'phone.*' => 'required|string|min:13|max:14',
            'school_id.*' => 'required|exists:schools,id',
            'class.*' => 'required|string|max:255',
            'year.*' => 'required|integer|min:1900',
        ], [
            'name.*.required' => 'Nama wajib diisi',
            'phone.*.required' => 'Nomor telepon wajib diisi',
            'phone.*.min' => 'Nomor telepon minimal 13 karakter',
            'phone.*.max' => 'Nomor telepon maksimal 14 karakter',
            'school_id.*.required' => 'Sekolah wajib dipilih',
            'school_id.*.exists' => 'Sekolah tidak valid',
            'class.*.required' => 'Kelas wajib diisi',
            'class.*.max' => 'Kelas maksimal 255 karakter',
            'year.*.required' => 'Tahun wajib diisi',
            'year.*.integer' => 'Tahun harus berupa angka',
            'year.*.min' => 'Tahun minimal 1900',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $recommendation = Recommendation::findOrFail($id);

        $names = $request->input('name');
        $phones = $request->input('phone');
        $schools = $request->input('school_id');
        $classes = $request->input('class');
        $years = $request->input('year');

        $data = [
            'identity_user' => Auth::user()->identity,
            'name' => $names[0],
            'phone' => $phones[0],
            'school_id' => $schools[0],
            'class' => $classes[0],
            'year' => $years[0],
            'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
        ];

        $recommendation->update($data);
        return back()->with('message', 'Data rekomendasi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recommendation = Recommendation::findOrFail($id);
        $recommendation->delete();

        return response()->json(['Data rekomendasi berhasil dihapus!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $request, $id)
    {
        $recommendation = Recommendation::findOrFail($id);
        $data = [
            'status' => $request->input('status'),
        ];
        $recommendation->update($data);

        return back()->with('message', 'Data rekomendasi berhasil diubah!');
    }
}
