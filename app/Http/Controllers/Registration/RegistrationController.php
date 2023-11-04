<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total =  Registration::count();
        return view('pages.payment.registration.index')->with([
            'total' => $total,
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

    public function get_all()
    {
        $registrationQuery = Registration::query();
        $registrationQuery->with('applicant');

        $dateVal = request('date', 'all');
        $pmbVal = request('pmbVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $percentVal = request('percentVal', 'all');

        if ($dateVal !== 'all') {
            $registrationQuery->where('date', $dateVal);
        }
        if ($pmbVal !== 'all') {
            $registrationQuery->where('pmb', $pmbVal);
        }
        if ($sessionVal !== 'all') {
            $registrationQuery->where('session', $sessionVal);
        }
        if ($percentVal !== 'all') {
            $registrationQuery->whereRaw('nominal < (deal * ' . $percentVal . ')');
        }

        $registrations = $registrationQuery->orderByDesc('created_at')->get();

        return response()->json(['registrations' => $registrations]);
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
            'pmb' => ['required'],
            'date' => ['required'],
            'identity_user' => ['required'],
            'nominal' => ['required', 'integer'],
            'deal' => ['required', 'integer'],
            'discount' => ['required', 'integer'],
            'session' => ['required'],
        ]);

        $data = [
            'pmb' => $request->input('pmb'),
            'date' => $request->input('date'),
            'identity_user' => $request->input('identity_user'),
            'nominal' => $request->input('nominal'),
            'deal' => $request->input('deal'),
            'discount' => $request->input('discount'),
            'desc_discount' => $request->input('desc_discount'),
            'session' => $request->input('session'),
        ];

        Registration::create($data);
        return back()->with('message', 'Data registrasi berhasil ditambahkan!');
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
            $registration = Registration::findOrFail($id);
            $registration->delete();
            return session()->flash('message', 'Data registrasi berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
