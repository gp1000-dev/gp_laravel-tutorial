<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
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
            'tasks' => $tasks,
        ]);
    }

    /**
     *  タスク作成フォーム
     *  フォルダIDを取得してTask新規作成画面を表示するコントローラー
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
            'folder_id' => $folder->id,
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
        // フォルダーとタスクのリレーション（関連性）をチェックする
        $this->checkRelation($folder, $task);

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
        // フォルダーとタスクのリレーション（関連性）をチェックする
        $this->checkRelation($folder, $task);

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

    /*
    タスク削除
    タスクを削除してDBに書き込む処理のコントローラー
     */
    public function destroy(Folder $folder,Task $task)
    {
        // フォルダーとタスクのリレーション（関連性）をチェックする
        $this->checkRelation($folder,$task);
        //一致するidが見つかるかどうか確認
        $delete_task = Task::findOrFail($task->id);
        //タスクを削除する処理
        $delete_task->delete();
        //タスク一覧画面へのリダイレクト
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    /**
     *  フォルダとタスクの関連性チェック
     *  フォルダとタスクの関連性があるか調べるコントローラー
     *  機能：リレーション（関連性）がなければ処理を中断して404エラー処理をする
     *  用途：フォルダとタスクの関連性チェックとエラー処理
     *  @param Folder $folder
     *  @param Task $task
     */
    private function checkRelation(Folder $folder, Task $task)
    {
        // フォルダーインスタンスのIDとタスクインスタンスのフォルダーIDが一致しなければif文を実行する
        // folder_idはDBの外部キーの参照元にfoldersテーブルのidを指定していますので、同じユーザーなら本来一致するはずです
        if ($folder->id !== $task->folder_id) {
            // 処理を中断して404エラーを実施する
            abort(404);
        }
    }
}
