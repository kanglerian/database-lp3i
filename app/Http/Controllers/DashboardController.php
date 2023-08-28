<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SourceSetting;
use App\Models\User;
use App\Models\UserUpload;
use App\Models\FileUpload;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userupload = UserUpload::where(['identity_user' => Auth::user()->identity, 'fileupload_id' => 11])->get();
        $fileupload = FileUpload::where('namefile', 'bukti-pembayaran')->get();
        return view('pages.dashboard.index')->with([
            'userupload' => $userupload,
            'fileupload' => $fileupload,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_sources($pmb = null)
    {
        $sourcesQuery = SourceSetting::select('source_setting.id', 'source_setting.name', DB::raw('COUNT(applicants.source_id) as count'));

        if ($pmb !== 'all' && $pmb !== null) {
            $sourcesQuery->where('applicants.pmb', $pmb);
        }

        $sourcesQuery->leftJoin('applicants', 'source_setting.id', '=', 'applicants.source_id');

        $sourcesQuery->groupBy('source_setting.id', 'source_setting.name');

        $sources = $sourcesQuery->get();

        return response()->json(['sources' => $sources]);
    }

    public function get_presenters($pmb = null)
    {
        $presentersQuery = User::select('users.identity', 'users.name', DB::raw('COUNT(applicants.identity_user) as count'))
            ->leftJoin('applicants', 'users.identity', '=', 'applicants.identity_user')
            ->where('users.role', 'P');

        if ($pmb !== 'all' && $pmb !== null) {
            $presentersQuery->where('applicants.pmb', $pmb);
        }

        $presentersQuery->groupBy('users.identity', 'users.name');
        $presenters = $presentersQuery->get();

        return response()->json(['presenters' => $presenters]);
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
        //
    }
}