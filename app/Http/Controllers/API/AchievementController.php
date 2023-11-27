<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AchievementController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'identity_user' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string'],
            'year' => ['required'],
            'result' => ['required'],
        ], [
            'name.required' => 'Nama prestasi tidak boleh kosong.',
            'level.required' => 'Tingkatan tidak boleh kosong.',
            'year.required' => 'Tahun tidak boleh kosong.',
            'result.required' => 'Hasil tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $request->validate([
            'identity_user' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string'],
            'year' => ['required'],
            'result' => ['required'],
        ]);

        $data = [
            'identity_user' => $request->identity_user,
            'name' => $request->name,
            'level' => $request->level,
            'year' => $request->year,
            'result' => $request->result,
        ];

        Achievement::create($data);

        return response()->json(['success' => true, 'message' => 'Prestasi sudah ditambahkan.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        return response()->json(['success' => true, 'message' => 'Data prestasi sudah dihapus.']);
    }
}
