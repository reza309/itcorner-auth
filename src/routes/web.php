<?php

use App\Http\Controllers\Auth\ItCornerAuthController as AuthItCornerAuthController;
use Illuminate\Support\Facades\Route;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;

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
Route::group(['middleware' => ['web']], function () {
    Route::get('login',[ItCornerAuthController::class,"loginView"])->name('login')->middleware('isLoggedIn');
    Route::post('login',[ItCornerAuthController::class,"login"])->name('login');
    Route::get('register',[ItCornerAuthController::class,"registerView"])->name('register')->middleware('isLoggedIn');
    Route::post('register',[ItCornerAuthController::class,'register'])->name('register');
    Route::get('logout',[ItCornerAuthController::class,'logout'])->name('logout');
    Route::get('dashboard',[ItCornerAuthController::class,'dashboard'])->name('dashboard')->middleWare('isAuthenticate');
});

Route::middleware(['isAuthenticate'])->group(function () {
    
    // write here only othenticated route

});
