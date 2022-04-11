<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     *  タスク一覧
     *  Folderモデルの全てのデータをDBから取得するコントローラー
     *  GET /folders/{id}/tasks
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function index(Folder $folder)
    {
        // （ログイン済み）ユーザーのフォルダを取得する
        $folders = auth()->user()->folders()->get();

        // ユーザーによって選択されたフォルダに紐づくタスクを取得する
        // get()：値を取得する関数（この場合はwhere関数で生成されたSQL文を発行して値を取得する）
        $tasks = $folder->tasks()->get();

        // indexテンプレートにFolderモデルの全てのデータを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/index', [
            // 'folders'に$foldersの値を代入する
            'folders' => $folders,
            // ユーザーによって選択された"$folder"に$idの値を代入する
            'current_folder_id' => $folder->id,
            // 'tasks'に$tasksを代入する
            'tasks' => $tasks
        ]);
    }

    /**
     *  タスク作成フォーム
     *  フォルダIDを取得するためのコントローラー
     *  GET /folders/{id}/tasks/create
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function showCreateForm(Folder $folder)
    {
        // createテンプレートにフォルダーIDを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/create', [
            'folder' => $folder->id,
        ]);
    }

    /**
     *  タスク作成
     *  タスクを新規作成してDBに書き込む処理のコントローラー
     *  GET /folders/{id}/tasks/create
     *  @param Folder $folder
     *  @param CreateTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request)
    {
        /* 新規作成のタスク（タイトル）をDBに書き込む処理 */
        // タスクモデルのインスタンスを作成する
        $task = new Task();
        // タイトルに入力値を代入する
        $task->title = $request->title;
        // 期限に入力値を代入する
        $task->due_date = $request->due_date;
        // $folderに紐づくタスクを生成する（インスタンスの状態をデータベースに書き込む）
        $folder->tasks()->save($task);

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

    /**
     *  タスク編集フォーム
     *  タスクIDを取得するためのコントローラー
     *  GET /folders/{id}/tasks/{task_id}/edit
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        // createテンプレートにフォルダーIDを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     *  タスク編集
     *  タスクを編集（更新）してDBに書き込む処理のコントローラー
     *  GET /folders/{id}/tasks/{task_id}/edit
     *  @param Folder $folder
     *  @param Task $task
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        /* 編集（更新）のタスクをDBに上書きする処理 */
        // タイトルに入力値を代入する
        $task->title = $request->title;
        // 状態に入力値を代入する
        $task->status = $request->status;
        // 期限に入力値を代入する
        $task->due_date = $request->due_date;
        // インスタンスの状態をデータベースに書き込む
        $task->save();

        /* 上記の処理実行後のリダイレクト */
        // リダイレクト：別URLへの転送（リクエストされたURLとは別のURLに直ちに再リクエストさせます）
        // route('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        // redirect():リダイレクトを実施する関数
        // route():ルートPathを指定する関数
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }
}
