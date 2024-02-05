<?php

use App\Http\Controllers\API\AchievementController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Report\RegisterBySchoolController;
use App\Http\Controllers\API\Report\ReportStudentsAdmissionController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\UserUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\ApplicantHistoryController;
use App\Http\Controllers\API\Report\ReportAplikanController;
use App\Http\Controllers\API\Report\SourceDatabaseByPresenterController;
use App\Http\Controllers\API\Report\SourceDatabaseByWilayahController;
use App\Http\Controllers\API\Report\WilayahDatabaseByPresenterController;
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

/* Route SBPMB */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'get_user']);
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::patch('/user/update/{identity}', [UserController::class, 'update']);
    Route::patch('/user/updateprogram/{identity}', [UserController::class, 'update_program']);
    Route::patch('/user/updatefamily/{identity}', [UserController::class, 'update_family']);
    Route::post('/achievement', [AchievementController::class, 'store']);
    Route::delete('/achievement/{id}', [AchievementController::class, 'destroy']);
    Route::post('/userupload', [UserUploadController::class, 'store']);
    Route::delete('/userupload/{id}', [UserUploadController::class, 'destroy']);
    Route::post('/organization', [OrganizationController::class, 'store']);
    Route::delete('/organization/{id}', [OrganizationController::class, 'destroy']);
});

Route::get('/user/info/{identity}', [UserController::class, 'info_user']);

Route::post('/storewebsite', [ApplicantController::class, 'store_website'])->name('applicants.api.website');
Route::post('/storehistory', [ApplicantHistoryController::class, 'store_history'])->name('applicants.api.history');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/school/getall', [SchoolController::class, 'get_all'])->name('school.getall');
Route::get('/school/getsources', [SchoolController::class, 'get_sources'])->name('school.getsources');
Route::get('/database/{identity}', [ApplicantController::class, 'show'])->name('applicants.api.show');

Route::get('/report/database/presenter/source', [SourceDatabaseByPresenterController::class, 'get_all']);
Route::get('/report/database/wilayah/source', [SourceDatabaseByWilayahController::class, 'get_all']);

Route::get('/report/database/presenter/wilayah', [WilayahDatabaseByPresenterController::class, 'get_all']);

Route::get('/report/database/aplikan/aplikan', [ReportAplikanController::class, 'aplikan']);
Route::get('/report/database/aplikan/daftar', [ReportAplikanController::class, 'daftar']);
Route::get('/report/database/aplikan/registrasi', [ReportAplikanController::class, 'registrasi']);
Route::get('/report/database/aplikan/files', [ReportAplikanController::class, 'files']);


Route::get('/report/database/perolehanpmb', [ReportStudentsAdmissionController::class, 'get_all']);

Route::get('/report/database/register/school', [RegisterBySchoolController::class, 'get_all']);
