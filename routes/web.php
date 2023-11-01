<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Socialite\GithubController;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::controller(SignUpController::class)->prefix('sign-up')->group(function () {
        Route::get('/', 'renderPage')->name('signUp');
        Route::post('/', 'handle')->name('signUp.handle');
    });

    Route::controller(LoginController::class)->prefix('login')->group(function () {
        Route::get('/', 'renderPage')->name('login');
        Route::post('/', 'handle')->name('login.handle');
    });

    Route::controller(ForgotPasswordController::class)->prefix('forgot-password')->group(function () {
        Route::get('/', 'renderPage')->name('forgot');
        Route::post('/', 'handle')->name('forgot.handle');
    });

    Route::controller(ResetPasswordController::class)->prefix('reset-password')->group(function () {
        Route::get('/{token}', 'renderPage')->name('password.reset');
        Route::post('/', 'handle')->name('reset.handle');
    });
});

Route::middleware('auth')->group(function () {
    Route::delete('/logout', LogoutController::class)->name('logout');
});

Route::name('socialite.')->prefix('auth/socialite')->group(function () {
    Route::controller(GithubController::class)->name('github')->prefix('github')->group(function () {
        Route::get('/', 'github');
        Route::get('/callback', 'githubCallback')->name('.callback');
    });
});