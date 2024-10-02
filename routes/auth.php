<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
  Route::get('/register', [RegisterController::class, 'create'])->name('register');
  Route::post('/register', [RegisterController::class, 'store']);

  Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
  Route::post('/login', [AuthenticationController::class, 'store']);
});
