<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');

Route::resource('dashboard', \App\Http\Controllers\HomeController::class)->middleware('auth');

Route::resource('transfert', \App\Http\Controllers\TransfertController::class)->middleware('auth');

Route::get('retrait-uniquement', [\App\Http\Controllers\TransfertController::class, 'retraitUniquement'])->name('retrait-uniquement')->middleware('auth');

Route::get('transferts/{query}', [\App\Http\Controllers\TransfertController::class, 'report'])->name('transferts.report')->middleware('auth');

Route::get('printtck', [\App\Http\Controllers\TransfertController::class, 'printview'])->name('printtck');

Route::resource('home', \App\Http\Controllers\HomeController::class)->middleware('auth');

Route::get('profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile')->middleware('auth');

Route::resource('utilisateurs', \App\Http\Controllers\UserController::class)->middleware('auth');
