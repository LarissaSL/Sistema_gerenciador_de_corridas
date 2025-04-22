<?php

use App\Http\Controllers\Dashboard\ApiDashboardController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\TwoFactorAuthController;
use App\Http\Controllers\Password\ForgetPasswordController;
use App\Http\Controllers\Register\RegisterController;
use Illuminate\Support\Facades\Route;


Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login.home');
    Route::post('/login', 'login')->name('login.auth');
});

Route::controller(TwoFactorAuthController::class)->group(function() {
    Route::get('/two-factor-auth/send', 'sendToken')->name('twoFactorAuth.send');
    Route::get('/two-factor-auth/form', 'formToken')->name('twoFactorAuth.form');
    Route::get('/two-factor-auth/verify', 'verifyToken')->name('twoFactorAuth.verify');
    Route::post('/two-factor-auth/verify-json', 'verifyTokenJson')->name('twoFactorAuth.verifyJson');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
});

Route::controller(ForgetPasswordController::class)->group(function () {
    Route::get('/forget-password', 'index')->name('forgetPassword');
    Route::post('/forget-password/send-email', 'sendEmail')->name('forgetPassword.sendEmail');
    Route::get('/forget-password/{token}/recover', 'recover')->name('forgetPassword.recover');
    Route::post('/forget-password/{token}/update', 'updatePassword')->name('forgetPassword.updatePassword');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

// Rotas para devolução em JSON
Route::prefix('v1')->group(function () {
    Route::controller(ApiDashboardController::class)->group(function () {
        Route::get('evolution/year={year}&month={month?}', 'evolutionAnnual')
        ->where([
            'year' => '\d{4}',
            'month' => '\d{1,2}'
        ])
        ->name('dashboard.evolution.annual');
        Route::get('evolution/finance-data', 'financeData')->name('dashboard.finance.data');
        Route::get('evolution/races-data', 'racesData')->name('dashboard.races.data');
    });
});

Route::get('/teste', function () {
    return view('testing.test');
});
