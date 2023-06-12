<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\PresenterController;
use App\Http\Controllers\API\BaksoController;
use App\Http\Controllers\API\KlinikController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/applicants', [ApplicantController::class, 'getAll'])->name('applicants.api.index');
Route::post('/storewebsite', [ApplicantController::class, 'store_website'])->name('applicants.api.website');


Route::get('/presenters', [PresenterController::class, 'getAll'])->name('presenters.api.index');

Route::resource('bakso', BaksoController::class);
Route::resource('klinik', KlinikController::class);

Route::get('/poli', [KlinikController::class, 'poli'])->name('klinik.poli');