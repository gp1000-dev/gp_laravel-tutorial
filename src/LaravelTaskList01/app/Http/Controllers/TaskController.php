<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class TaskController extends Controller
{
    // 入門3：コントローラーのテストコード
    /**
     *  Folderモデルの全てのデータをDBから取得するコントローラー
     *
     *  @param int $id
     *  @return string
     */
    public function index(int $id)
    {
        // Folderモデルの全てのデータをDBから取得する
        $folders = Folder::all();
        // indexテンプレートにFolderモデルの全てのデータを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/index', [
            'folders' => $folders,
            "current_folder_id"=>$id
        ]);
    }
}
