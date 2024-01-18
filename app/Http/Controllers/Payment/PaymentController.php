<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daftar_total_nominal = StatusApplicantsEnrollment::sum('nominal');
        $daftar_total_debit = StatusApplicantsEnrollment::sum('debit');
        $cash = $daftar_total_nominal - $daftar_total_debit;
        $total = StatusApplicantsRegistration::sum('nominal');
        $turnover = StatusApplicantsRegistration::sum('deal');
        return view('pages.payment.index')->with([
            'total' => $total,
            'turnover'=> $turnover,
            'cash' => $cash
        ]);
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
        //
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
        try {
            $presenter = StatusApplicantsEnrollment::findOrFail($id);
            $presenter->delete();
            return session()->flash('message', 'Data pendaftaran berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
