<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\Applicant;
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
            'name' => $request->input('name'),
            'namefile' => $request->input('namefile'),
            'typefile' => $request->berkas->extension(),
        ];

        $file = $request->berkas->extension();
        $encodedFile = base64_encode(file_get_contents($request->berkas->getPathName()));

        $payload = [
            'identity' => Auth::user()->identity,
            'namefile' => $request->input('namefile'),
            'typefile' => $request->berkas->extension(),
            'image' => $encodedFile,
        ];

        if ($payload['namefile'] === 'foto') {
            $dataku = [
                'avatar' => $request->input('namefile') . '.' . $request->berkas->extension(),
            ];
            $user = User::findOrFail(Auth::user()->id);
            $user->update($dataku);
        }

        try {
            $response = Http::post('https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/pmbupload', $payload);
            $responseData = $response->json();
            UserUpload::create($data);
            return back()->with('message', 'Berkas berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim permintaan ke server.');
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
        $userupload = UserUpload::where('identity_user', $identity)->get();
        $data = [];
        foreach ($userupload as $key => $upload) {
            $data[] = $upload->namefile;
        }
        $success = FileUpload::whereIn('namefile', $data)->get();
        $fileupload = FileUpload::whereNotIn('namefile', $data)->get();
        return view('pages.userupload.index')->with([
            'userupload' => $userupload,
            'fileupload' => $fileupload,
            'success' => $success,
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
        $user_upload = UserUpload::findOrFail($id);

        $payload = [
            'identity' => $user_upload->identity_user,
            'namefile' => $user_upload->namefile,
            'typefile' => $user_upload->typefile,
        ];

        if ($user_upload->namefile == 'foto') {
            $dataku = [
                'avatar' => null,
            ];
            $user = User::findOrFail(Auth::user()->id);
            $user->update($dataku);
        }

        try {
            $response = Http::delete('https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/remove', $payload);
            $responseData = $response->json();
            $user_upload->delete();
            return back()->with('message', 'Data upload berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
