<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\User;
use App\Models\UserUpload;
use Illuminate\Http\Request;

class UserUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $data = [
            'identity_user' => $request->identity_user,
            'fileupload_id' => $request->fileupload_id,
            'typefile' => $request->typefile,
        ];

        if ($request->fileupload_id == 1) {
            $file = FileUpload::findOrFail($request->fileupload_id);
            $dataku = [
                'avatar' => $file->namefile . '.' . $request->typefile,
            ];
            $user = User::where('identity', $request->identity_user)->first();
            $user->update($dataku);
        }

        UserUpload::create($data);

        return response()->json(['success' => true, 'message' => 'Berkas telah diunggah!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $upload = UserUpload::findOrFail($id);
        $upload->delete();
        return response()->json(['success' => true, 'message' => 'Data berkas sudah dihapus.']);
    }
}
