<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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

/* Laravel welcome Page */
Route::get('/', function () {
    return view('welcome');
});
/* hello world page */
Route::get('/hello', [HelloController::class,"index"]);

/*
 * 認証を求めるミドルウェアのルーティング
 * 機能：ルートグループによる一括適用とミドルウェアによるページ認証
 * 用途：未ログイン状態でのアクセスをできないようにする
 */
Route::group(['middleware' => 'auth'], function() {
    /* home page */
    Route::get('/', [HomeController::class,"index"])->name('home');
    /* index page */
    Route::get("/folders/{id}/tasks", [TaskController::class,"index"])->name("tasks.index");
    /* folder new create pages */
    Route::get('/folders/create', [FolderController::class,"showCreateForm"])->name('folders.create');
    Route::post('/folders/create', [FolderController::class,"create"]);
    /* tasks new create pages */
    Route::get('/folders/{id}/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
    Route::post('/folders/{id}/tasks/create', [TaskController::class,"create"]);
    /* tasks new edit pages */
    Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
    Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"edit"]);
});

/* certification pages （会員登録・ログイン・ログアウト・パスワード再設定など） */
Auth::routes();
