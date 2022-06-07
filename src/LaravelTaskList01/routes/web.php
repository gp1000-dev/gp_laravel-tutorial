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

    /* folder new create pages */
    Route::get('/folders/create', [FolderController::class,"showCreateForm"])->name('folders.create');
    Route::post('/folders/create', [FolderController::class,"create"]);

    /*
    * ポリシーをミドルウェアを介して使用する
    * 機能：ルートグループによる一括適用とミドルウェアによるポリシーの呼び出し
    * 用途：Folderモデル(FolderPolicyポリシー)で定義されたviewメソッドのポリシーを使用する
    * 'can:第1引数,第2引数':'can:認可処理の種類,ポリシーに渡すルートパラメーター（URL の変数部分）'
    */
    Route::group(['middleware' => 'can:view,folder'], function() {
        /* index page */
        Route::get("/folders/{folder}/tasks", [TaskController::class,"index"])->name("tasks.index");
        /* tasks new create pages */
        Route::get('/folders/{folder}/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', [TaskController::class,"create"]);
        /* tasks new edit pages */
        Route::get('/folders/{folder}/tasks/{task}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', [TaskController::class,"edit"]);
        /* tasks dekete pages */
        Route::post('/folders/{folder}/tasks/{task}', [TaskController::class,"destroy"])->name('tasks.destroy');
    });
});

/* certification pages （会員登録・ログイン・ログアウト・パスワード再設定など） */
Auth::routes();
