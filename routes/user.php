<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customer'], function(){
    Route::get('/register-form', [\App\Http\Controllers\Frontend\CustomerController::class, 'registerForm'])->name('customer.register.form');
    Route::post('/register', [\App\Http\Controllers\Frontend\CustomerController::class, 'register'])->name('customer.register');
    Route::get('/login-form', [\App\Http\Controllers\Frontend\CustomerController::class, 'loginForm'])->name('customer.login.form');
    Route::post('/login', [\App\Http\Controllers\Frontend\CustomerController::class, 'login'])->name('customer.login');
    Route::get('/forgot/form', [\App\Http\Controllers\Frontend\CustomerController::class, 'passwordForgotForm'])->name('customer.forgot.password.form');
    Route::post('/forgot', [\App\Http\Controllers\Frontend\CustomerController::class, 'passwordForgot'])->name('customer.forgot.password');
    Route::get('/password/reset/form/{email}', [\App\Http\Controllers\Frontend\CustomerController::class, 'passwordResetForm'])->name('customer.new.password.form');
    Route::post('/password/update/{email}', [\App\Http\Controllers\Frontend\CustomerController::class, 'newPasswordUpdate'])->name('customer.new.password');
    Route::get('/dashboard', [\App\Http\Controllers\Frontend\CustomerController::class, 'dashboard'])->name('user.deshboard');
    Route::get('/profile', [\App\Http\Controllers\Frontend\CustomerController::class, 'userProfile'])->name('user.profile');
    Route::post('/profile/update', [\App\Http\Controllers\Frontend\CustomerController::class, 'userProfileUpadet']);
    Route::post('/password/update', [\App\Http\Controllers\Frontend\CustomerController::class, 'passwordUpdate']);
});