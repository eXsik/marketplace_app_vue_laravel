<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(callback: function () {
  Route::get('/register', [RegisterController::class, 'create'])->name('register');
  Route::post('/register', [RegisterController::class, 'store']);

  Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
  Route::post('/login', [AuthenticationController::class, 'store']);

  Route::get('/forgot-password', [ResetPasswordController::class, 'requestPassword'])->name('password.request');
  Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->name('password.email');
  Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');
  Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');

});

Route::middleware('auth')->group(callback: function () {
  Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
  Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

  Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

  Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
  Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});