<?php

use App\Http\Controllers\Question\HomeController;
use App\Http\Controllers\Question\Scholarship\QuestionController;
use App\Http\Controllers\Question\Scholarship\ResultController;
use App\Http\Controllers\Target\TargetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Enrollment\EnrollmentController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Registration\RegistrationController;
use App\Http\Controllers\AchivementController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SchoolController;
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

/* Route Dashboard */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('get/dashboard/all', [DashboardController::class, 'get_all'])->name('dashboard.get_all');
    Route::get('get/dashboard/sources/{pmb?}', [DashboardController::class, 'get_sources'])->name('dashboard.sourceget');
    Route::get('get/dashboard/sourcesdaftar/{pmb?}', [DashboardController::class, 'get_sources_daftar'])->name('dashboard.sourcedaftarget');
    Route::get('get/dashboard/presenters/{pmb?}', [DashboardController::class, 'get_presenters'])->name('dashboard.presenterget');
    Route::get('quicksearch/{name?}', [DashboardController::class, 'quick_search'])->name('quicksearch');
    Route::get('quicksearchstatus', [DashboardController::class, 'quick_search_status'])->name('quicksearchstatus');
});

/* Route School */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('school', SchoolController::class);
    Route::get('get/schools', [SchoolController::class, 'get_all'])->name('schools.get');
    Route::post('import/schools', [SchoolController::class, 'import'])->name('school.import');
});

/* Route Database  */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('database', ApplicantController::class);
    Route::resource('histories', ApplicantHistoryController::class);
    /* Import from Spreadsheet */
    Route::get('import/applicants', [ApplicantController::class, 'import'])->name('applicant.import');
    Route::post('importupdate/applicants', [ApplicantController::class, 'import_update'])->name('applicant.importupdate');
    /* Export to Excel */
    Route::get('applicants/export/{dateStart?}/{dateEnd?}/{yearGrad?}/{schoolVal?}/{birthdayVal?}/{pmbVal?}/{sourceVal?}/{statusVal?}', [ApplicantController::class, 'export'])->name('applicants.export');
    /* Get data from Javascript in blade */
    Route::get('get/databases', [ApplicantController::class, 'get_all'])->name('database.get');
    Route::get('get/databasesbeasiswa', [ApplicantController::class, 'get_beasiswa'])->name('database.getbeasiswa');
    Route::get('isapplicant/{identity?}', [ApplicantController::class, 'is_applicant'])->name('database.is_applicant');
    Route::get('isregister/{identity?}', [ApplicantController::class, 'is_register'])->name('database.is_register');
    Route::get('isdaftar/{identity?}', [ApplicantController::class, 'is_daftar'])->name('database.is_daftar');
    Route::get('isschoolarship/{identity?}', [ApplicantController::class, 'is_schoolarship'])->name('database.is_schoolarship');
    Route::get('chat/{identity?}', [ApplicantController::class, 'chats'])->name('database.chat');
    Route::get('file/{identity?}', [ApplicantController::class, 'files'])->name('database.file');
    Route::get('achievement/{identity?}', [ApplicantController::class, 'achievements'])->name('database.achievement');
    Route::get('organization/{identity?}', [ApplicantController::class, 'organizations'])->name('database.organization');
    Route::get('scholarship/{identity?}', [ApplicantController::class, 'scholarships'])->name('database.scholarship');
    Route::get('print/database/{id}', [ApplicantController::class, 'print'])->name('database.print');
});

/* Route Presenter  */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('presenter', PresenterController::class);
    Route::get('get/presenters', [PresenterController::class, 'get_all'])->name('presenter.get');
});

/* Route Presenter  */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('user', UserController::class)->middleware(['auth', 'role:A']);
    Route::get('get/users/{role?}/{status?}', [UserController::class, 'get_all'])->name('user.get');
    Route::patch('user/update_account/{id}', [UserController::class, 'update_account'])->name('user.update_account');
    Route::patch('user/change_password/{id}', [UserController::class, 'change_password'])->name('user.change_password');
    Route::patch('user/change/{id}', [UserController::class, 'status'])->name('user.change');
    Route::get('print/user/{id}', [UserController::class, 'print'])->name('user.print');
    Route::patch('presenter/change/{id}', [PresenterController::class, 'status'])->name('presenter.change');
    Route::patch('presenter/change_password/{id}', [PresenterController::class, 'change_password'])->name('presenter.password');
});

/* Route Profile */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::patch('profile/update_account/{id}', [ProfileController::class, 'update_account'])->name('profile.update_account');
    Route::patch('profile/change_password/{id}', [ProfileController::class, 'change_password'])->name('profile.change_password');
});

/* Route Student */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('userupload', UserUploadController::class);
    Route::post('payment', [UserUploadController::class, 'upload_pembayaran'])->name('upload.payment');
});

/* Route Enrollment */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('enrollment', EnrollmentController::class);
    Route::get('get/enrollments', [EnrollmentController::class, 'get_all'])->name('enrollment.get');
});

/* Route Registration */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('registration', RegistrationController::class);
    Route::get('get/registrations', [RegistrationController::class, 'get_all'])->name('registration.get');
});

/* Route Target */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('target', TargetController::class);
    Route::get('get/targets', [PresenterController::class, 'get_target'])->name('presenter.target');
});

/* Route Payment */
Route::middleware(['auth', 'status:1', 'role:P'])->group(function () {
    Route::resource('payment', PaymentController::class);
});

/* Route Setting */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::resource('setting', SettingController::class);
    Route::resource('programtype', ProgramTypeController::class);
    Route::resource('source', SourceController::class);
    Route::resource('fileupload', FileUploadController::class);
    Route::resource('applicantstatus', ApplicantStatusController::class);
    Route::resource('followup', FollowUpController::class);
});

/* Route Scholarship */
Route::middleware(['auth', 'status:1', 'role:A'])->group(function () {
    Route::get('questions', [HomeController::class, 'index'])->name('question.index');
    Route::get('questions/scholarship', [ResultController::class, 'index'])->name('scholarship.index');
    Route::get('questions/scholarship/questions', [QuestionController::class, 'index'])->name('scholarship.question');
});

/* Route Achievement */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('achievements', AchivementController::class);
});

/* Route Organization */
Route::middleware(['auth', 'status:1'])->group(function () {
    Route::resource('organizations', OrganizationController::class);
});

require __DIR__ . '/auth.php';
