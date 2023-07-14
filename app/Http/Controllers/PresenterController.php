<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        return view('pages.presenter.index');
    }

    public function get_all()
    {
        $presenters = User::where('role', 'P')->get();
        return response()
            ->json([
                'presenters' => $presenters,
            ])
            ->header('Content-Type', 'application/json');
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
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users', 'max:255'],
                'phone' => ['required', 'string', 'unique:users', 'max:15'],
                'role' => ['string'],
                'status' => ['string'],
                'password' => ['required', 'min:8', 'confirmed'],
            ]);

            $data = [
                'identity' => mt_rand(1, 1000000000),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'role' => 'P',
                'status' => '1',
            ];

            User::create($data);

            return back()->with('message', 'Data presenter berhasil ditambahkan!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
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
        $presenter = User::findOrFail($id);
        return view('pages.presenter.edit')->with([
            'presenter' => $presenter,
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
        try {
            $presenter = User::findOrFail($id);
            $request->validate([
                'identity' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($id)],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'phone' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($id)],
                'role' => ['string'],
                'status' => ['string', 'not_in:Pilih status'],
            ]);
            $data = [
                'identity' => $request->input('identity'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => strpos($request->input('phone'), '0') === 0 ? '62' . substr($request->input('phone'), 1) : $request->input('phone'),
                'role' => 'P',
                'status' => $request->input('status'),
            ];
            $presenter->update($data);
            return back()->with('message', 'Data presenter berhasil diubah!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
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
            $presenter = User::findOrFail($id);
            $presenter->delete();
    
            return session()->flash('message', 'Data presenter berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
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
        try {
            $presenter = User::findOrFail($id);
            $request->validate([
                'status' => ['string'],
            ]);
            $data = [
                'status' => $presenter->status == '0' ? '1' : '0',
            ];
            $presenter->update($data);
            return back()->with('message', 'Status presenter berhasil diubah!');.
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request, $id)
    {
        try {
            $presenter = User::findOrFail($id);
            $request->validate([
                'password' => ['required', 'min:8', 'confirmed'],
            ]);
            $data = [
                'password' => Hash::make($request->input('password')),
            ];
            $presenter->update($data);
            return back()->with('message', 'Password berhasil diubah!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
