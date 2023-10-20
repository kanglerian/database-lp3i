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
            'identity_user' => $request->identity,
            'fileupload_id' => $request->fileupload_id,
            'typefile' => $request->typefile,
        ];
        return response()->json(['success' => true, 'message' => $data]);

        if ($request->fileupload_id == 1) {
            $file = FileUpload::findOrFail($request->fileupload_id);
            $dataku = [
                'avatar' => $file->namefile . '.' . $request->typefile,
            ];
            $user = User::where('identity', $request->identity)->first();
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
        $achievement = UserUpload::findOrFail($id);
        $achievement->delete();
        return response()->json(['success' => true, 'message' => 'Data prestasi sudah dihapus.']);
    }
}
