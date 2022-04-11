<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     *  フォルダ作成フォーム
     *  Folder新規作成画面を表示するコントローラー
     *  @return string
     */
    public function showCreateForm()
    {
        // createテンプレートにFolder新規作成画面のPathを渡した結果を返す
        // view('遷移先のbladeファイル名');
        return view('folders/create');
    }

    /**
     *  フォルダ作成
     *  Folderを新規作成してDBに書き込む処理のコントローラー
     *  @param Folder $folder
     *  @param CreateFolder $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateFolder $request)
    {
        /* 新規作成のフォルダー名（タイトル）をDBに書き込む処理 */
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // （ログイン）ユーザーに紐づけて保存する
        Auth::user()->folders()->save($folder);

        /* 上記の処理実行後のリダイレクト */
        // リダイレクト：別URLへの転送（リクエストされたURLとは別のURLに直ちに再リクエストさせます）
        // route('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        // redirect():リダイレクトを実施する関数
        // route():ルートPathを指定する関数
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
