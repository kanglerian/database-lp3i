<?php

use App\Http\Controllers\API\AchievementController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\UserUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApplicantController;
use App\Http\Controllers\API\ApplicantHistoryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/get', [UserController::class,'get_user'])->name('users.get');
Route::patch('/user/update/{identity}', [UserController::class,'update'])->name('users.update');
Route::patch('/user/updatefamily/{identity}', [UserController::class,'update_family'])->name('users.updatefamily');

Route::post('/storewebsite', [ApplicantController::class, 'store_website'])->name('applicants.api.website');
Route::post('/storehistory', [ApplicantHistoryController::class, 'store_history'])->name('applicants.api.history');

Route::post('/achievement', [AchievementController::class, 'store'])->name('achievements.api.store');
Route::delete('/achievement/{id}', [AchievementController::class, 'destroy'])->name('achievements.api.destroy');

Route::post('/userupload', [UserUploadController::class, 'store'])->name('useruploads.api.store');
Route::delete('/userupload/{id}', [UserUploadController::class, 'destroy'])->name('useruploads.api.destroy');

Route::post('/organization', [OrganizationController::class, 'store'])->name('organizations.api.store');
Route::delete('/organization/{id}', [OrganizationController::class, 'destroy'])->name('organizations.api.destroy');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/school/getall', [SchoolController::class, 'get_all'])->name('school.getall');

