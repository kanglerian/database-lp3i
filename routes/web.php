<?php

use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantStatusController;
use App\Http\Controllers\ApplicantHistoryController;
use App\Http\Controllers\PresenterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('dashboard', DashboardController::class)->middleware(['auth']);

Route::resource('school', SchoolController::class)->middleware(['auth','status:1','role:A']);
Route::get('get/schools', [SchoolController::class, 'get_all'])->name('schools.get')->middleware(['auth','status:1','role:A']);
Route::post('import/schools', [SchoolController::class, 'import'])->middleware(['auth','status:1','role:A'])->name('school.import');

Route::get('get/dashboard/sources/{pmb?}', [DashboardController::class, 'get_sources'])->name('dashboard.sourceget')->middleware(['auth','status:1']);
Route::get('get/dashboard/presenters/{pmb?}', [DashboardController::class, 'get_presenters'])->name('dashboard.presenterget')->middleware(['auth','status:1']);

Route::post('payment', [UserUploadController::class, 'upload_pembayaran'])->middleware(['auth'])->name('upload.payment');

Route::resource('database', ApplicantController::class)->middleware(['auth','status:1','role:P']);

Route::get('get/databases', [ApplicantController::class, 'get_all'])->name('database.get')->middleware(['auth','status:1','role:P']);

Route::get('applicants/export/{dateStart?}/{dateEnd?}/{yearGrad?}/{schoolVal?}/{birthdayVal?}/{pmbVal?}/{sourceVal?}/{statusVal?}', [ApplicantController::class, 'export'])->name('applicants.export');

Route::resource('histories', ApplicantHistoryController::class)->middleware(['auth','status:1','role:P']);

Route::resource('presenter', PresenterController::class)->middleware(['auth','role:A']);
Route::get('get/presenters', [PresenterController::class, 'get_all'])->name('presenter.get')->middleware(['auth','status:1','role:A']);

Route::resource('user', UserController::class)->middleware(['auth','role:A']);
Route::get('get/users/{role?}/{status?}', [UserController::class, 'get_all'])->name('user.get')->middleware(['auth','role:P']);
Route::patch('user/update_account/{id}', [UserController::class, 'update_account'])->name('user.update_account')->middleware(['auth','role:A','status:1']);
Route::patch('user/change_password/{id}', [UserController::class, 'change_password'])->name('user.change_password')->middleware(['auth','status:1','role:A']);

Route::patch('user/change/{id}', [UserController::class, 'status'])->name('user.change')->middleware(['auth','status:1','role:A']);

Route::get('print/user/{id}', [UserController::class, 'print'])->name('user.print')->middleware(['auth','role:A']);

Route::get('print/database/{id}', [ApplicantController::class, 'print'])->name('database.print')->middleware(['auth','role:P']);

Route::patch('presenter/change/{id}', [PresenterController::class, 'status'])->name('presenter.change')->middleware(['auth','status:1','role:A']);
Route::patch('presenter/change_password/{id}', [PresenterController::class, 'change_password'])->name('presenter.password')->middleware(['auth','status:1','role:A']);

Route::resource('profile', ProfileController::class)->middleware(['auth']);

Route::patch('profile/update_account/{id}', [ProfileController::class, 'update_account'])->name('profile.update_account')->middleware(['auth','status:1']);
Route::patch('profile/change_password/{id}', [ProfileController::class, 'change_password'])->name('profile.change_password')->middleware(['auth','status:1']);

Route::resource('userupload', UserUploadController::class)->middleware(['auth','role:S']);


Route::resource('setting', SettingController::class)->middleware(['auth','role:A']);
Route::resource('programtype', ProgramTypeController::class)->middleware(['auth','role:A']);
Route::resource('source', SourceController::class)->middleware(['auth','role:A']);
Route::resource('fileupload', FileUploadController::class)->middleware(['auth','role:A']);
Route::resource('applicantstatus', ApplicantStatusController::class)->middleware(['auth','role:A']);
Route::resource('followup', FollowUpController::class)->middleware(['auth','role:A']);

require __DIR__.'/auth.php';
