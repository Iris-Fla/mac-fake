<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;



Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/menu', [MenuController::class, 'index'])->middleware('auth');

Route::get('hello', 'App\Http\Controllers\HelloController@index');
Route::get('menutest', 'App\Http\Controllers\MenutestController@index');

Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/del', [CartController::class, 'del'])->name('cart.del');
Route::delete('/cart/{itemId}', [CartController::class, 'remove'])->name('cart.remove');