<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;


Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login.home');
    Route::post('/login', 'login')->name('login.auth');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

Route::get('/teste', function () {
    return view('testing.test');
});

Route::get('/forcaErro', function() {
    throw new Exception("Teste de erro no Laravel 11!");
});
