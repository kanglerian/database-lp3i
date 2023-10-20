<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

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
         $request->validate([
             'identity_user' => ['required', 'string', 'max:255'],
             'name' => ['required', 'string', 'max:255'],
             'position' => ['required', 'string'],
             'year' => ['required'],
         ]);

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
