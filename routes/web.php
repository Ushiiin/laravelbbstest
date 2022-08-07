<?php

use Illuminate\Support\Facades\Route;

// コントローラーごとに追記する必要あり
use App\Http\Controllers\SampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BbsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\TimelineUploadController;
use App\Http\Controllers\SimpleViewController;

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

// アップロードフォームを表示
Route::get('/up/file_upload', [FileUploadController::class, "index"])->name('file_upload.index');
// アップロード処理をする
Route::post('/up/file_upload/action', [FileUploadController::class, "action"])->name('file_upload.action');

// アップロードフォームを表示
Route::get('/up/timeline_upload', [TimelineUploadController::class, "index"])->name('timeline_upload.index');
// アップロード処理をする
Route::post('/up/timeline_upload/action', [TimelineUploadController::class, "action"])->name('timeline_upload.action');

// アップロードフォームを表示
Route::get('/up/simple_view', [SimpleViewController::class, "index"]);