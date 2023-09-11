<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantStatus;

class ApplicantStatusController extends Controller
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
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => $request->input('name'),
        ];

        ApplicantStatus::create($data);
        return redirect('setting')->with('message', 'Data status berhasil ditambahkan!');
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
        $status = ApplicantStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => $request->input('name'),
        ];

        $status->update($data);
        return redirect('setting')->with('message', 'Data status berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = ApplicantStatus::findOrFail($id);
        $status->delete();
        return redirect('setting')->with('message', 'Data status berhasil dihapus!');
    }
}
