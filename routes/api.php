<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\ApplicantHistoryController;
use App\Http\Controllers\API\PresenterController;
use App\Http\Controllers\API\BaksoController;
use App\Http\Controllers\API\KlinikController;
use App\Http\Controllers\API\UserController;

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

Route::post('/storewebsite', [ApplicantController::class, 'store_website'])->name('applicants.api.website');
Route::post('/storehistory', [ApplicantHistoryController::class, 'store_history'])->name('applicants.api.history');