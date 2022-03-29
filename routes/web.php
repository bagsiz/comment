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
    return view('index');
});

Route::prefix('comments')->group(function () {
    Route::get('/', [\App\Http\Controllers\CommentController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\CommentController::class, 'store']);
});
