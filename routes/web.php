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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/client', function () {
    return view('client');
});

Route::get('test', function () {
    event(new App\Events\MyEvent('Someone'));
    return "Event has been sent!";
});

Route::get('/serveur', [\App\Http\Controllers\TestEvent::class, 'index']);

Route::resource('dashboard', \App\Http\Controllers\DashboardController::class)->middleware('auth');

Route::resource('transfert', \App\Http\Controllers\TransfertController::class)->middleware('auth');

Route::get('transferts/{query}', [\App\Http\Controllers\TransfertController::class, 'report'])->name('transferts.report')->middleware('auth');

Route::get('printtck', [\App\Http\Controllers\TransfertController::class, 'printview'])->name('printtck');

Route::resource('home', \App\Http\Controllers\HomeController::class)->middleware('auth');
