<?php

use App\Http\Controllers\Auth\ItCornerAuthController as AuthItCornerAuthController;
// use App\Http\Controllers\Auth\ItCornerProfileController as ItCornerProfileController;
use Illuminate\Support\Facades\Route;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerProfileController;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerFileUploadController;
use ItCorner\Auth\Http\Controllers\Auth\MailController;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerForgetPassword;
use ItCorner\Auth\Routes\ItAuth;

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
// itAuth::route($data=['verify'=>true]);
Route::group(['middleware' => ['web']], function () {
    Route::get('login/',[ItCornerAuthController::class,"loginView"])->name('login')->middleware('isLoggedIn');
    Route::post('login/',[ItCornerAuthController::class,"login"])->name('login');
    Route::get('register/',[ItCornerAuthController::class,"registerView"])->name('register')->middleware('isLoggedIn');
    Route::post('register/',[ItCornerAuthController::class,'register'])->name('register');
    Route::get('logout/',[ItCornerAuthController::class,'logout'])->name('logout');
    Route::get('dashboard/',[ItCornerAuthController::class,'dashboard'])->name('dashboard')->middleWare('isAuthenticate');
    Route::get('profile/',[ItCornerProfileController::class,'profileView'])->name('profile')->middleWare('isAuthenticate');
    Route::post('profile/',[ItCornerProfileController::class,'profileStore'])->name('profile')->middleWare('isAuthenticate');
    Route::post('profileUpload/',[ItCornerFileUploadController::class,'userFileUpload'])->name('profileUpload')->middleWare('isAuthenticate');
    // mail verification
    Route::get('mail-verify/',[MailController::class,'mailVerificationView'])->name('mail-verify');
    Route::post('mail-verify/',[MailController::class,'mailVerification'])->name('mail-verify');
    Route::get('mail-verify/send',[MailController::class,'mailSendSuccess'])->name('mail-send');
    Route::get('mail-verfiy/confirm/{mailId}',[MailController::class,'verificationConfirm'])->name('mail-confirm');

    // forget password
    Route::get('user/forget-password/',[ItCornerForgetPassword::class,'sendLinkView'])->name('forget-password');
    Route::post('user/forget-password/',[ItCornerForgetPassword::class,'sendLink'])->name('forget-password');
    Route::get('/forget-password/confirm/{forgetLink}',[ItCornerForgetPassword::class,'forgetPasswordConfirm'])->name('forget-password-confirm');
    Route::post('/forget-password/confirm/{forgetLink}',[ItCornerForgetPassword::class,'saveNewPassword'])->name('forget-password-confirm');
});

Route::middleware(['isAuthenticate'])->group(function () {
    
    // write here only othenticated route

});
