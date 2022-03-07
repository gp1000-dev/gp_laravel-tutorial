<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Folder;
use App\Http\Requests\CreateTask;
class TaskController extends Controller
{
    /**
     *  Folderモデルの全てのデータをDBから取得するコントローラー
     *  GET /folders/{id}/tasks
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

    /**
     *  フォルダIDを取得するためのコントローラー
     *  GET /folders/{id}/tasks/create
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    public function showCreateForm(int $id)
    {
        // createテンプレートにフォルダーIDを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    /**
     *  タスクを新規作成してDBに書き込む処理のコントローラー
     *
     *  @param int $id
     *  @param CreateTask $request
     *  @return string
     */
    public function create(int $id, CreateTask $request)
    {
        // ユーザーによって選択されたフォルダを取得する
        // find()：一行分のデータを取得する関数
        $current_folder = Folder::find($id);

        /* 新規作成のタスク（タイトル）をDBに書き込む処理 */
        // タスクモデルのインスタンスを作成する
        $task = new Task();
        // タイトルに入力値を代入する
        $task->title = $request->title;
        // 期限に入力値を代入する
        $task->due_date = $request->due_date;
        // $current_folderに紐づくタスクを生成する（インスタンスの状態をデータベースに書き込む）
        $current_folder->tasks()->save($task);

        /* 上記の処理実行後のリダイレクト */
        // リダイレクト：別URLへの転送（リクエストされたURLとは別のURLに直ちに再リクエストさせます）
        // route('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        // redirect():リダイレクトを実施する関数
        // route():ルートPathを指定する関数
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
}
