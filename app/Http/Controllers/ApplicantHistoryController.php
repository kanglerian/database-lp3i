<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantHistory;
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
        ];

        ApplicantHistory::create($data);
        return back()->with('message', 'Data riwayat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role == 'P'){
            $user = Applicant::where(['identity' => $id, 'identity_user' => Auth::user()->identity])->firstOrFail();
        } elseif (Auth::user()->role == 'A') {
            $user = Applicant::where(['identity' => $id])->firstOrFail();
        }
        $histories = ApplicantHistory::where(['phone' => $user->phone])->orderBy('created_at','desc')->get();
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
        $history = ApplicantHistory::findOrFail($id);

        $data = [
            'phone' => $request->input('phone'),
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'result' => $request->input('result'),
        ];

        $history->update($data);
        return back()->with('message', 'Data riwayat berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $history = ApplicantHistory::findOrFail($id);
        $history->delete();
        return back()->with('message', 'Data riwayat berhasil dihapus!');
    }
}
