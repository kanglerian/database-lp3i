<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $total = User::where('role','P')->count();
        return view('pages.presenter.index')->with([
            'total' => $total,
        ]);
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
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'role' => 'P',
            'status' => '1',
        ];

        User::create($data);

        return redirect('presenter')->with('message', 'Data presenter berhasil ditambahkan!');
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
        $presenter = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'phone' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($id)],
            'role' => ['string'],
            'status' => ['string', 'not_in:Pilih status'],
        ]);
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => 'P',
            'status' => $request->input('status'),
        ];
        $presenter->update($data);
        return redirect('presenter')->with('message', 'Data presenter berhasil diubah!');
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
            return redirect('presenter')->with('error', $errorMessage);
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
        $presenter = User::findOrFail($id);
        $request->validate([
            'status' => ['string'],
        ]);
        $data = [
            'status' => $presenter->status == '0' ? '1' : '0',
        ];
        $presenter->update($data);
        return redirect('presenter')->with('message', 'Status presenter berhasil diubah!');
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
        $presenter = User::findOrFail($id);
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $data = [
            'password' => Hash::make($request->input('password')),
        ];
        $presenter->update($data);
        return redirect('presenter')->with('message', 'Password berhasil diubah!');
    }
}
