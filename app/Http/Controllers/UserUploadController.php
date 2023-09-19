<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\UserUpload;
use App\Models\FileUpload;

class UserUploadController extends Controller
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
            'berkas' => 'required|max:1024',
        ]);

        $data = [
            'identity_user' => Auth::user()->identity,
            'fileupload_id' => $request->input('fileupload_id'),
            'typefile' => $request->berkas->extension(),
        ];

        $encodedFile = base64_encode(file_get_contents($request->berkas->getPathName()));

        $payload = [
            'identity' => Auth::user()->identity,
            'namefile' => $request->input('namefile'),
            'typefile' => $request->berkas->extension(),
            'image' => $encodedFile,
        ];

        if ($data['fileupload_id'] == 1) {
            $file = FileUpload::findOrFail($request->input('fileupload_id'));
            $dataku = [
                'avatar' => $file->namefile . '.' . $request->berkas->extension(),
            ];
            $user = User::findOrFail(Auth::user()->id);
            $user->update($dataku);
        }

        $response = Http::post('https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/pmbupload', $payload);
        $status = $response->status();
        switch ($status) {
            case 200:
                UserUpload::create($data);
                return back()->with('message', 'Berkas berhasil ditambahkan!');
            case 500:
                return back()->with('error', 'Server belum dijalankan');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($identity)
    {
        $userupload = UserUpload::with('fileupload')->where('identity_user', $identity)->get();
        if (Auth::user()->identity == $identity) {
            $data = [];
            foreach ($userupload as $upload) {
                $data[] = $upload->fileupload_id;
            }
            $success = FileUpload::whereIn('id', $data)->get();
            $fileupload = FileUpload::whereNotIn('id', $data)->get();
            return view('pages.userupload.index')->with([
                'userupload' => $userupload,
                'fileupload' => $fileupload,
                'success' => $success,
            ]);
        } else {
            return back();
        }

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
        $user_upload = UserUpload::with('fileupload')->findOrFail($id);

        $payload = [
            'identity' => $user_upload->identity_user,
            'namefile' => $user_upload->fileupload->namefile,
            'typefile' => $user_upload->typefile,
        ];

        if ($user_upload->fileupload->namefile == 'foto') {
            $dataku = [
                'avatar' => null,
            ];
            $user = User::findOrFail(Auth::user()->id);
            $user->update($dataku);
        }

        $response = Http::delete('https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/remove', $payload);

        if ($response->successful()) {
            $user_upload->delete();
            session()->flash('message', 'Data berhasil dihapus');
        } else {
            $statusCode = $response->status();
            session()->flash('error', 'Gagal menghapus data (Kode status: ' . $statusCode . ')');
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload_pembayaran(Request $request)
    {
        $request->validate([
            'berkas' => 'required|max:1024',
        ]);

        $data = [
            'identity_user' => Auth::user()->identity,
            'fileupload_id' => $request->input('fileupload_id'),
            'typefile' => $request->berkas->extension(),
        ];

        $encodedFile = base64_encode(file_get_contents($request->berkas->getPathName()));

        $payload = [
            'identity' => Auth::user()->identity,
            'namefile' => $request->input('namefile'),
            'typefile' => $request->berkas->extension(),
            'image' => $encodedFile,
        ];

        $response = Http::post('https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/pmbupload', $payload);
        $status = $response->status();
        switch ($status) {
            case 200:
                UserUpload::create($data);
                return back()->with('message', 'Berkas berhasil ditambahkan!');
            case 500:
                return back()->with('error', 'Server belum dijalankan');
        }
    }
}