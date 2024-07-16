<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function kkn()
    {
        $schools = School::all();
        return view("data.kkn.index")->with([
            "schools" => $schools
        ]);
    }

    public function kkn_store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'phone' => ['required'],
                'school_id' => ['required'],
                'class' => ['required'],
                'year' => ['required'],
                'income_parent' => ['required'],
                'address' => ['required'],
            ],
            [
                'name.required' => 'Kolom nama lengkap tidak boleh kosong!',
                'phone.required' => 'Kolom no. whatsapp tidak boleh kosong!',
                'school_id.required' => 'Kolom sekolah tidak boleh kosong!',
                'class.required' => 'Kolom kelas tidak boleh kosong!',
                'year.required' => 'Kolom tahun lulus tidak boleh kosong!',
                'income_parent.required' => 'Kolom pendapatan orang tua tidak boleh kosong!',
                'address.required' => 'Kolom alamat lengkap tidak boleh kosong!',
            ],
        );

        $schoolCheck = School::where('id', $request->input('school_id'))->first();
        $schoolNameCheck = School::where('name', $request->input('school_id'))->first();

        $administrator = User::where(['role' => 'A'])->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            if ($schoolNameCheck) {
                $school = $schoolNameCheck->id;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->input('school_id')),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $schoolCreate = School::create($dataSchool);
                $school = $schoolCreate;
            }
        }

        $data = [
            'identity_user' => $administrator->identity,
            'name' => ucwords(strtolower($request->input('name'))),
            'phone' => $request->input('phone'),
            'school_id' => $school,
            'class' => $request->input('class'),
            'year' => $request->input('year'),
            'income_parent' => $request->input('income_parent'),
            'address' => $request->input('address'),
            'source_id' => 13,
        ];

        Recommendation::create($data);

        return redirect()->route('recommendation-data.input-kkn')->with('message', 'Berhasil menambahkan data rekomendasi KKN baru!');
    }
}
