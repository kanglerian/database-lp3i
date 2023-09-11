<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;

class FileUploadController extends Controller
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
            'accept' => ['required', 'string'],
        ]);

        $data = [
            'name' => $request->input('name'),
            'namefile' => strtolower(str_replace(' ','-', $request->input('name'))),
            'accept' => $request->input('accept'),
        ];

        FileUpload::create($data);
        return redirect('setting')->with('message', 'Data file berhasil ditambahkan!');
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
        $fileupload = FileUpload::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
            'accept' => ['required', 'string'],
        ]);

        $data = [
            'name' => $request->input('name'),
            'namefile' => strtolower(str_replace(' ','-', $request->input('name'))),
            'accept' => $request->input('accept'),
        ];

        $fileupload->update($data);
        return redirect('setting')->with('message', 'Data file upload berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fileupload = FileUpload::findOrFail($id);
        $fileupload->delete();
        return redirect('setting')->with('message', 'Data file upload berhasil dihapus!');
    }
}
