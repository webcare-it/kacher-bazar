<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vendor'], function(){
    Route::get('/registration', [App\Http\Controllers\Frontend\SupplierController::class, 'register'])->name('supplier.register');
    Route::post('/register', [App\Http\Controllers\Frontend\SupplierController::class, 'store'])->name('vendor.register.store');
    Route::get('/login/form', [App\Http\Controllers\Frontend\SupplierController::class, 'loginForm'])->name('vendor.login.form');
    Route::post('/login', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorLogin'])->name('vendor.login');
    Route::get('/forgot/password/form', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorForgotPasswordForm'])->name('vendor.forgot.password.form');
    Route::post('/forgot/password', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorForgotPassword'])->name('vendor.forgot.password');
    Route::get('/password/reset/form/{email}', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorPasswordResetForm'])->name('vendor.password.reset.form');
    Route::post('/new/password/{email}', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorNewPasswordSet'])->name('vendor.new.password');
});

//============== Social login ============//
Route::get('auth/google', [App\Http\Controllers\Frontend\SupplierController::class, 'loginWithGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\Frontend\SupplierController::class, 'loginWithGoogleCallback']);

Route::get('/supplier/dashboard', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorDeshboard'])->name('vendor.deshboard');
Route::get('/supplier/profile/setting', [App\Http\Controllers\Frontend\SupplierController::class, 'profileSetting'])->name('vendor.profile');
Route::get('/supplier/order/product', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorOrderProduct'])->name('vendor.product.order');
Route::get('/vendor/product/upload', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorProductUploadForm'])->name('vendor.product.upload.form');
Route::post('/vendor/product/store', [App\Http\Controllers\Frontend\SupplierController::class, 'vendorProductUpload'])->name('vendor.product.upload');
Route::get('/supplier/product/edit/{id}/{slug}', [App\Http\Controllers\Frontend\SupplierController::class, 'productsEdit'])->name('vendor.product.edit');
Route::post('/supplier/product/update/{id}', [App\Http\Controllers\Frontend\SupplierController::class, 'productsUpdate'])->name('vendor.product.update');
Route::get('/subcategory/list/{id}', [App\Http\Controllers\Frontend\SupplierController::class, 'categoryWiseSubcategory'])->name('category.wise.subcategory.list');

