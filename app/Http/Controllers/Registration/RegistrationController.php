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

        if ($dateVal !== 'all') {
            $registrationQuery->where('date', $dateVal);
        }
        if ($pmbVal !== 'all') {
            $registrationQuery->whereHas('applicant', function ($query) use ($pmbVal) {
                $query->where('pmb', $pmbVal);
            });
        }
        if ($sessionVal !== 'all') {
            $registrationQuery->where('session', $sessionVal);
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
            'date' => ['required'],
            'identity_user' => ['required', 'string'],
            'nominal' => ['required', 'integer'],
            'deal' => ['required', 'integer'],
            'discount' => ['required', 'integer'],
        ]);

        $data = [
            'date' => $request->input('date'),
            'identity_user' => $request->input('identity_user'),
            'nominal' => $request->input('nominal'),
            'deal' => $request->input('deal'),
            'discount' => $request->input('discount'),
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
