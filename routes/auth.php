<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(callback: function () {
  Route::get('/register', [RegisterController::class, 'create'])->name('register');
  Route::post('/register', [RegisterController::class, 'store']);

  Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
  Route::post('/login', [AuthenticationController::class, 'store']);


});

Route::middleware('auth')->group(callback: function () {
  Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
  Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

  Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});