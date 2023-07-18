<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PresenterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('database', ApplicantController::class)->middleware(['auth','status:1','role:P']);
Route::get('get/databases', [ApplicantController::class, 'get_all'])->name('database.get')->middleware(['auth','status:1']);
Route::get('databases/{id?}/edit/family', [ApplicantController::class, 'get_all'])->name('database.get')->middleware(['auth','status:1']);

Route::resource('presenter', PresenterController::class)->middleware(['auth','role:A']);
Route::get('get/presenters', [PresenterController::class, 'get_all'])->name('presenter.get')->middleware(['auth','status:1']);

Route::resource('user', UserController::class)->middleware(['auth']);
Route::get('get/users/{role?}/{status?}', [UserController::class, 'get_all'])->name('user.get')->middleware(['auth']);
Route::patch('user/update_account/{id}', [UserController::class, 'update_account'])->name('user.update_account')->middleware(['auth','status:1']);
Route::patch('user/change_password/{id}', [UserController::class, 'change_password'])->name('user.change_password')->middleware(['auth','status:1']);

Route::get('print/user/{id}', [UserController::class, 'print'])->name('user.print')->middleware(['auth']);

Route::patch('presenter/change/{id}', [PresenterController::class, 'status'])->name('presenter.change')->middleware(['auth','status:1']);
Route::patch('presenter/change_password/{id}', [PresenterController::class, 'change_password'])->name('presenter.password')->middleware(['auth','status:1']);

Route::resource('profile', ProfileController::class)->middleware(['auth']);
Route::patch('profile/update_account/{id}', [ProfileController::class, 'update_account'])->name('profile.update_account')->middleware(['auth','status:1']);
Route::patch('profile/change_password/{id}', [ProfileController::class, 'change_password'])->name('profile.change_password')->middleware(['auth','status:1']);

Route::resource('userupload', UserUploadController::class)->middleware(['auth','role:S']);

require __DIR__.'/auth.php';
