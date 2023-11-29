<?php

namespace App\Http\Controllers\Enrollment;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total =  Enrollment::count();
        return view('pages.payment.enrollment.index')->with([
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
        $enrollmentQuery = Enrollment::query();
        $enrollmentQuery->with('applicant');

        $dateVal = request('date', 'all');
        $pmbVal = request('pmbVal', 'all');
        $repaymentVal = request('repaymentVal', 'all');
        $registerVal = request('registerVal', 'all');
        $registerEndVal = request('registerEndVal', 'all');

        if ($dateVal !== 'all') {
            $enrollmentQuery->where('date', $dateVal);
        }
        if ($pmbVal !== 'all') {
            $enrollmentQuery->where('pmb', $pmbVal);
        }
        if ($repaymentVal !== 'all') {
            $enrollmentQuery->where('repayment', $repaymentVal);
        }
        if ($registerVal !== 'all') {
            $enrollmentQuery->where('register', $registerVal);
        }
        if ($registerEndVal !== 'all') {
            $enrollmentQuery->where('register_end', $registerEndVal);
        }

        $enrollments = $enrollmentQuery->orderByDesc('created_at')->get();

        return response()->json(['enrollments' => $enrollments]);
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
            'receipt' => ['required'],
            'register' => ['required'],
            'register_end' => ['required'],
            'nominal' => ['required'],
        ]);

        $data = [
            'pmb' => $request->input('pmb'),
            'date' => $request->input('date'),
            'identity_user' => $request->input('identity_user'),
            'receipt' => $request->input('receipt'),
            'register' => $request->input('register'),
            'register_end' => $request->input('register_end'),
            'nominal' => (int) str_replace('.', '', $request->input('nominal')),
            'repayment' => $request->input('repayment'),
            'debit' => (int) str_replace('.', '', $request->input('debit')),
        ];

        Enrollment::create($data);
        return back()->with('message', 'Data daftar berhasil ditambahkan!');
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
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();
            return session()->flash('message', 'Data pendaftaran berhasil dihapus!');
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
}
