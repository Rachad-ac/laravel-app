<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/etudiants', EtudiantController::class)->only([
    'index', 'create', 'edit'
]);
