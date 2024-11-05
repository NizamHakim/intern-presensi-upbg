<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kelas', function(){
    return view('kelas.daftar-kelas');
});