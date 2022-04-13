<!--
*   extends()：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section()：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを追加するHTMLを表示する
-->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">フォルダ</div>
                    <div class="panel-body">
                        <!-- herf属性を編集する -->
                        <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
                            フォルダを追加する
                        </a>
                    </div>
                    <div class="list-group">
                        <!-- PHP記述部分：テンプレとでは「＠」を用いて記述します -->
                        <!--
                        *    【folder一覧セクション】
                        *    foreach の中でTaskControllerから渡されたデータ $folders を参照する
                        *    $folders をループしてタイトルを全て表示する
                        -->
                        @foreach($folders as $folder)
                        <!--
                        *    アンカーリンクのhref属性を変数展開する
                        *    ルート関数：route('ルート名', [ルートURLのうち変数になっている部分（$folder->id）])
                        -->
                        <!-- フォルダ名を選択表示（水色）にする
                        *    $current_folder_id つまり閲覧されているフォルダの ID と ID 値が合致する場合のみ 'active' という HTML クラスを出力する（下記の通りに差し替え）
                        -->
                        <a href="{{ route('tasks.index', ['folder' => $folder->id]) }}" class="list-group-item {{ $current_folder_id === $folder->id ? 'active' : '' }}">
                            <!-- フォルダのタイトルを表示する -->
                            {{ $folder->title }}
                        </a>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="column col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">タスク</div>
                    <div class="panel-body">
                        <div class="text-right">
                        <!-- タスクを追加する のリンクを変更する -->
                        <a href="{{ route('tasks.create', ['folder' => $current_folder_id]) }}" class="btn btn-default btn-block">
                            タスクを追加する
                        </a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>状態</th>
                                <th>期限</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PHP記述部分：テンプレとでは「＠」を用いて記述します -->
                            <!--
                            *    【task一覧セクション】
                            *    foreach の中でTaskControllerから渡されたデータ $tasks を参照する
                            *    $tasks をループして値を全て表示する
                            -->
                            @foreach($tasks as $task)
                            <tr>
                                <!-- タスクのタイトルを表示する -->
                                <td>{{ $task->title }}</td>
                                <!-- タスクの状態を表示する -->
                                <td>
                                    <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                </td>
                                <!-- タスクの期限を表示する -->
                                <td>{{ $task->formatted_due_date }}</td>
                                <!-- 編集のリンクを表示する -->
                                <td><a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}">編集</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
