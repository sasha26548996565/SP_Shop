<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', HomeController::class)->name('home');

Route::name('auth.')->group(function () {
    Route::controller(SignUpController::class)->prefix('sign-up')->group(function () {
        Route::get('/', 'renderPage')->name('signUp');
        Route::post('/handle', 'handle')->name('signUp.handle');
    });

    Route::controller(LoginController::class)->prefix('login')->group(function () {
        Route::get('/', 'renderPage')->name('login');
        Route::post('/handle', 'handle')->name('login.handle');
    });

    Route::controller(ForgotPasswordController::class)->prefix('forgot-password')->group(function () {
        Route::get('/', 'renderPage')->name('forgotPassword');
    });

    Route::controller(ResetPasswordController::class)->prefix('reset-password')->group(function () {
        Route::get('/', 'renderPage')->name('resetPassword');
    });
});