<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
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
        // all()：全てのデータを取得する関数
        $folders = Folder::all();

        // ユーザーによって選択されたフォルダを取得する
        // find()：一行分のデータを取得する関数
        $current_folder = Folder::find($id);

        // ユーザーによって選択されたフォルダに紐づくタスクを取得する
        // get()：値を取得する関数（この場合はwhere関数で生成されたSQL文を発行して値を取得する）
        $tasks = $current_folder->tasks()->get();

        // indexテンプレートにFolderモデルの全てのデータを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/index', [
            // 'folders'に$foldersの値を代入する
            'folders' => $folders,
            // ユーザーによって選択された"current_folder_id"に$idの値を代入する
            'current_folder_id' => $current_folder->id,
            // 'tasks'に$tasksを代入する
            'tasks' => $tasks
        ]);
    }
}
