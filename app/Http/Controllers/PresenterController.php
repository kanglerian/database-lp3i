<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PresenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presenters = User::all();
        return view('pages.presenter.index')->with([
            'presenters' => $presenters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.presenter.create');
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
            'nik' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'status' => ['integer', 'min:0'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        
        $data = [
            'nik' => $request->input('nik'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' =>  Hash::make($request->input('password')),
            'role' => 'P',
            'status' => 1,
        ];
        User::create($data);
        return back()->with('message', 'Data presenter berhasil ditambahkan!');
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
        $presenter = User::findOrFail($id);
        return view('pages.presenter.edit')->with([
            'presenter' => $presenter
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
        $presenter = User::findOrFail($id);
        $request->validate([
            'nik' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'status' => ['boolean', 'not_in:Pilih status'],
            'phone' => ['required', 'string', 'max:15'],
            'status' => ['integer', 'min:0']
        ]);
        $data = [
            'nik' => $request->input('nik'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => 'P',
            'status' => $request->input('status')
        ];
        $presenter->update($data);
        return back()->with('message', 'Data presenter berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $presenter = User::findOrFail($id);
        $presenter->delete();

        return session()->flash('message', 'Data presenter berhasil dihapus!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $presenter = User::findOrFail($id);
        $request->validate([
            'status' => ['integer', 'min:0']
        ]);
        $data = [
            'status' => $presenter->status == 0 ? 1 : 0,
        ];
        $presenter->update($data);
        return back()->with('message', 'Status presenter berhasil diubah!');
    }

}
