<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Klinik;

class KlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kliniks = Klinik::all();

        return response()->json([
            'kliniks' => $kliniks,
        ])->header('Content-Type', 'application/json');;
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
        try {
            $data = [
                'nama' => $request->input('nama'),
                'usia' => $request->input('usia'),
                'poli' => $request->input('poli'),
            ];
            
            Bakso::create($data);
            return response()->json(['message' => 'Pasien telah ditambahkan']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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
        try {
            $klinik = Klinik::findOrFail($id);
            $data = [
                'nama' => $request->input('nama'),
                'usia' => $request->input('usia'),
                'poli' => $request->input('poli'),
            ];
            $klinik->update($data);
            return response()->json(['message' => 'Pasien telah diubah']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $klinik = Klinik::findOrFail($id);
            $klinik->delete();
            return response()->json(['message' => 'Pasien telah dihapus']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }



    public function poli()
    {
        $polis = array(
            array(
                "name" => "Poli Gigi"
            ),
            array(
                "name" => "Poli Anak"
            ),
            array(
                "name" => "Poli Bedah Saraf"
            ),
            array(
                "name" => "Poli Orthopaedi"
            ),
            array(
                "name" => "Poli Kulit"
            )
        );

        return response()->json($polis);
    }
}
