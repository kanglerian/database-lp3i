<?php

namespace App\Http\Controllers\Target;

use App\Http\Controllers\Controller;
use App\Models\TargetDatabase;
use Illuminate\Http\Request;

class TargetDatabaseController extends Controller
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
            'pmb' => ['required'],
            'identity_user' => ['required'],
            'total' => ['required', 'integer'],
        ]);

        $data = [
            'pmb' => $request->input('pmb'),
            'identity_user' => $request->input('identity_user'),
            'total' => $request->input('total'),
        ];

        TargetDatabase::create($data);
        return back()->with('message', 'Data target database berhasil ditambahkan!');
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
        $request->validate([
            'edit_total' => ['required', 'integer'],
        ]);

        $target = TargetDatabase::findOrFail($id);

        $data = [
            'total' => $request->input('edit_total'),
        ];

        $target->update($data);
        return back()->with('message', 'Data target database berhasil diubah!');
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
            $target = TargetDatabase::findOrFail($id);
            $target->delete();
            return session()->flash('message', 'Data target database berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
