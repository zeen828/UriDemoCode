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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/uri/srt', \App\Http\Controllers\UriSrtsController::class);
// Route::resource('/uri/log', UriLogsController::class);

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::post('/', [\App\Http\Controllers\HomeController::class, 'post'])->name('home.post');

Route::get('/go/{srt}', [\App\Http\Controllers\HomeController::class, 'go'])->name('home.go');
Route::get('/go/{srt}/info', [\App\Http\Controllers\HomeController::class, 'info'])->name('home.info');
