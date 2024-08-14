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
        $files = FileUpload::paginate(5);
        return view('pages.setting.file.index')->with([
            'files' => $files
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.setting.file.create');
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
            'name' => ucwords(strtolower($request->input('name'))),
            'namefile' => strtolower(str_replace(' ','-', ucwords(strtolower($request->input('name'))))),
            'accept' => $request->input('accept'),
        ];

        FileUpload::create($data);
        return back()->with('message', 'Data berkas berhasil ditambahkan!');
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
        $file = FileUpload::findOrFail($id);
        return view('pages.setting.file.edit')->with([
            'file' => $file
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
        $fileupload = FileUpload::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
            'accept' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'namefile' => strtolower(str_replace(' ','-', ucwords(strtolower($request->input('name'))))),
            'accept' => $request->input('accept'),
        ];

        $fileupload->update($data);
        return back()->with('message', 'Data berkas berhasil diubah!');
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
        return back()->with('message', 'Data berkas berhasil dihapus!');
    }
}
