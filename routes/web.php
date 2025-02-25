<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function () {
    return view('testing.test');
});

Route::get('/forcaErro', function() {
    throw new Exception("Teste de erro no Laravel 11!");
});
