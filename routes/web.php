<?php

use App\Http\Controllers\CompareController;
use App\Http\Controllers\CsvDataController;
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
    return view('main');
});

Route::post('/compare/load', [CsvDataController::class, 'uploadData'])->name('loadData');

Route::post('/compare', [CompareController::class, 'compare'])->name('comparecsv');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
