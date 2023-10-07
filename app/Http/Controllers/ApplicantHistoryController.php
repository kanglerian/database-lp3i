<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Applicant;

class ApplicantHistoryController extends Controller
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
        $data = [
            'phone' => $request->input('phone'),
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'result' => $request->input('result'),
            'report' => $request->input('report'),
        ];
        $response = Http::post('https://api.politekniklp3i-tasikmalaya.ac.id/history/store', $data);

        if ($response->successful()) {
            return back()->with('message', 'Data riwayat berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Data riwayat gagal ditambahkan');
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
        if (Auth::user()->role == 'P') {
            $user = Applicant::where(['identity' => $id, 'identity_user' => Auth::user()->identity])->firstOrFail();
        } elseif (Auth::user()->role == 'A') {
            $user = Applicant::where(['identity' => $id])->firstOrFail();
        }

        if ($user->phone == null) {
            return back()->with('error', 'Nomor telpon belum dicantumkan');
        }

        $response = Http::get('https://api.politekniklp3i-tasikmalaya.ac.id/history/phone/' . $user->phone);

        $status = $response->status();
        switch ($status) {
            case 200:
                $histories = $response->json();
                break;
            case 500:
                return back()->with('error', 'Server belum dijalankan');

        }
        return view('pages.database.history')->with([
            'user' => $user,
            'histories' => $histories,
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
        $data = [
            'phone' => $request->input('phone'),
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'result' => $request->input('result'),
            'report' => $request->input('report'),
        ];
        $response = Http::post('https://api.politekniklp3i-tasikmalaya.ac.id/history/update/' . $id, $data);

        if ($response->successful()) {
            return back()->with('message', 'Data riwayat berhasil diupdate!');
        } else {
            return back()->with('error', 'Data riwayat gagal diupdate');
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

    }
}
