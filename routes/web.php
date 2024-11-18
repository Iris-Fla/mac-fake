<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', 'App\Http\Controllers\HelloController@index');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');