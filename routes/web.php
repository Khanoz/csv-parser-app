<?php

use App\Http\Controllers\csvtestController;
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

Route::post('/test', [csvtestController::class, 'store'])->name('testcsv');

/*Route::post('/test', function() {
    return view('test');
});*/

Route::get('/testAutoComplete', function() {
    return view('autoCompleteTest');
});

Route::match(array('GET', 'POST'), '/compare', function()
{
    return view('compare');
});

Route::post('/compare/load', function() {
    return view('loadData');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
