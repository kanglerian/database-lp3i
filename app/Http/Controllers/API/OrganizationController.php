<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
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
            'position' => ['required', 'string'],
            'year' => ['required'],
        ], [
            'name.required' => 'Nama organisasi tidak boleh kosong.',
            'position.required' => 'Jabatan tidak boleh kosong.',
            'year.required' => 'Tahun tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

         $data = [
             'identity_user' => $request->identity_user,
             'name' => $request->name,
             'position' => $request->position,
             'year' => $request->year,
         ];

         Organization::create($data);

         return response()->json(['success' => true, 'message' => 'Organisasi sudah ditambahkan.']);
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         $achievement = Organization::findOrFail($id);
         $achievement->delete();
         return response()->json(['success' => true, 'message' => 'Data organisasi sudah dihapus.']);
     }
}
