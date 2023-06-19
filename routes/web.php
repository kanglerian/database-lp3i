<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PresenterController;

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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('database', ApplicantController::class)->middleware(['auth','status:1']);
Route::get('get/databases', [ApplicantController::class, 'get_all'])->name('database.get')->middleware(['auth','status:1']);

Route::resource('presenter', PresenterController::class)->middleware(['auth','role:A']);
Route::get('get/presenters', [PresenterController::class, 'get_all'])->name('presenter.get')->middleware(['auth','status:1']);

Route::patch('presenter/change/{id}', [PresenterController::class, 'status'])->name('presenter.change')->middleware(['auth','status:1']);
Route::patch('presenter/change_password/{id}', [PresenterController::class, 'change_password'])->name('presenter.password')->middleware(['auth','status:1']);

require __DIR__.'/auth.php';
