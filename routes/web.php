<?php

use Illuminate\Support\Facades\Route;

// コントローラーごとに追記する必要あり
use App\Http\Controllers\SampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BbsController;

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

// /bbs にアクセスが来た場合にBbsControllerのindex関数を参照します。
// Route::get('/bbs', 'BbsController@index');
Route::get('/bsb', [BbsController::class, 'index']);
// methodがpostなことに注意
Route::post('/bsb', [BbsController::class, 'create']);

// Route::get('/user', 'UserController@index');
Route::get('/user', [UserController::class, 'index']);

Route::get('/sample', [SampleController::class, 'showPage']);