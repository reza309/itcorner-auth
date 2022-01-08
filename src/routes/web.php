<?php

use App\Http\Controllers\Auth\ItCornerAuthController as AuthItCornerAuthController;
use Illuminate\Support\Facades\Route;
use ItCorner\Auth\Http\Controllers\Auth\ItCornerAuthController;

Route::group(['middleware' => ['web']], function () {
    Route::get('login',[ItCornerAuthController::class,"login"])->name('login');
    Route::get('register',[ItCornerAuthController::class,"registerView"])->name('register');
    Route::post('register',[ItCornerAuthController::class,'register'])->name('register');
});

