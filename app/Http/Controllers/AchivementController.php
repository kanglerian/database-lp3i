<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchivementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'identity_user' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'not_in:Pilih tingkat'],
            'year' => ['required'],
            'result' => ['required'],
        ]);

        $data = [
            'identity_user' => $request->input('identity_user'),
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'year' => $request->input('year'),
            'result' => $request->input('result'),
        ];

        Achievement::create($data);

        return back()->with('message', 'Data prestasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $achievements = Achievement::where('identity_user', $id)->get();
        return response()->json([
            'achievements' => $achievements,
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
            $achievement = Achievement::findOrFail($id);
            $achievement->delete();
            return session()->flash('message', 'Data prestasi berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
