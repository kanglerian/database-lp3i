<?php

use App\Http\Controllers\API\AchievementController;
use App\Http\Controllers\API\BeasiswaPPO\AuthController;
use App\Http\Controllers\API\BeasiswaPPO\ApplicantController as ApplicantPPOController;
use App\Http\Controllers\API\BeasiswaPPO\ValidationController;
use App\Http\Controllers\API\Dashboard\RegisterProgramController;
use App\Http\Controllers\API\Dashboard\RekapPerolehanPMB;
use App\Http\Controllers\API\Dashboard\SalesController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\PresenterController;
use App\Http\Controllers\API\Psikotest\AuthPsikotestController;
use App\Http\Controllers\API\RecommendationController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Report\RegisterByProgramController;
use App\Http\Controllers\API\Report\RegisterBySchoolController;
use App\Http\Controllers\API\Report\RegisterBySourceController;
use App\Http\Controllers\API\Report\ReportStudentsAdmissionController;
use App\Http\Controllers\API\Report\TargetByMonthController;
use App\Http\Controllers\API\Report\TargetByPresenterController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\Target\VolumeController;
use App\Http\Controllers\API\UserUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\ApplicantHistoryController;

use App\Http\Controllers\API\Report\RegisterBySchoolYearController;
use App\Http\Controllers\API\Report\ReportAplikanController;
use App\Http\Controllers\API\Report\SourceDatabaseByPresenterController;
use App\Http\Controllers\API\Report\SourceDatabaseByWilayahController;
use App\Http\Controllers\API\Report\WilayahDatabaseByPresenterController;
use App\Http\Controllers\API\UserController;

use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CobaController;

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

/* JWT */
Route::group(['middleware' => 'api', 'prefix' => 'auth/psikotest'], function() {
    Route::post('/register', [AuthPsikotestController::class, 'register']);
    Route::post('/login', [AuthPsikotestController::class, 'login']);
    Route::get('/logout', [AuthPsikotestController::class, 'logout']);
    Route::get('/profile', [AuthPsikotestController::class, 'profile']);
});

Route::group(['middleware' => 'api', 'prefix' => 'beasiswappo'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/presenter', [AuthController::class, 'profile_by_phone']);
    Route::patch('/applicant/update/{identity}', [ApplicantPPOController::class, 'update']);
    Route::patch('/applicant/update-prodi/{identity}', [ApplicantPPOController::class, 'update_prodi']);
    Route::patch('/applicant/update-family/{identity}', [ApplicantPPOController::class, 'update_family']);
    Route::post('/userupload', [UserUploadController::class, 'store']);
    Route::delete('/userupload/{id}', [UserUploadController::class, 'destroy']);
});

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
Route::get('/user/check/{id}', [UserController::class, 'check_user']);

Route::get('/presenters', [PresenterController::class, 'get_all']);
Route::get('/presenters/page', [PresenterController::class, 'get_page']);
Route::get('/applicants/scholarships', [ApplicantController::class, 'get_scholarship']);

Route::post('/storewebsite', [ApplicantController::class, 'store_website'])->name('applicants.api.website');
Route::post('/storehistory', [ApplicantHistoryController::class, 'store_history'])->name('applicants.api.history');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login-psikotes', [LoginController::class, 'login_psikotes'])->name('login.psikotes');

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
Route::get('/report/database/register/program', [RegisterByProgramController::class, 'get_all']);
Route::get('/report/database/register/school/year', [RegisterBySchoolYearController::class, 'get_all']);
Route::get('/report/database/register/source', [RegisterBySourceController::class, 'get_all']);
Route::get('/report/database/target/presenter', [TargetByPresenterController::class, 'get_all']);
Route::get('/report/database/target/month', [TargetByMonthController::class, 'get_all']);

Route::get('/target/volume/getvolumes', [VolumeController::class, 'get_volumes'])->name('volume.get_volumes');
Route::get('/target/volume/getrevenues', [VolumeController::class, 'get_revenues'])->name('volume.get_revenues');
Route::get('/target/volume/getdatabases', [VolumeController::class, 'get_databases'])->name('volume.get_databases');

Route::get('/dashboard/register/program', [RegisterProgramController::class, 'get_all']);
Route::get('/dashboard/register/rekapperolehanpmb', [RekapPerolehanPMB::class, 'get_all']);
Route::get('/dashboard/sales', [SalesController::class, 'get_all']);

Route::get('/recommendation', [RecommendationController::class, 'get_all']);

Route::post('/resetpassword', [ResetPasswordController::class, 'reset']);

Route::prefix('beasiswa-ppo')->group(function(){
    Route::post('/check', [ValidationController::class,'check_validation'])->name('beasiswa-ppo.check_validation');
});

Route::get('/lee', [CobaController::class,'index']);