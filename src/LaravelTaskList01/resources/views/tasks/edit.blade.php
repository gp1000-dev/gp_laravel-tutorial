<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：styles を指定
*   用途：javascriptライブラリー「flatpickr 」のスタイルシートを指定
-->
@section('styles')
    @include('share.flatpickr.styles')
@endsection

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを追加するHTMLを表示する
-->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">タスクを編集する</div>
                    <div class="panel-body">
                        <!-- エラーがある場合はIF文の処理を実行する -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                <!-- エラーメッセージをループで全て列挙して表示する -->
                                @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">タイトル</label>
                                <!--
                                *   value：直前の値または $task->title の値を取得する
                                *   old：セッション（直前の）値を取得する関数
                                -->
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ old('title') ?? $task->title }}"
                                />
                            </div>
                            <div class="form-group">
                                <label for="status">状態</label>
                                <select name="status" id="status" class="form-control">
                                    <!-- Task::STATUS をループしてoptionで状態を全て表示する -->
                                    @foreach(\App\Models\Task::STATUS as $key => $val)
                                        <!--
                                        *   直前に取得または選択した値をセッション値として入力欄に表示するようにする
                                        *   value：old関数の値と選択した状態（'selected'）が一致した場合に実行する
                                        *   old：第二引数のある場合は セッション（直前の）値または第二引数の指定した値を取得する
                                        -->
                                        <option value="{{ $key }}" {{ $key == old('status', $task->status) ? 'selected' : '' }}>
                                            {{ $val['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="due_date">期限</label>
                                <!--
                                *   value：直前の値または $task->formatted_due_date の値を取得する
                                *   old：セッション（直前の）値を取得する関数
                                -->
                                <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') ?? $task->formatted_due_date }}" />
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">送信</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection

<!--
*   section：子ビューで定義したデータを表示する
*   セクション名：scripts を指定
*   目的：flatpickr によるカレンダー形式による日付選択
*   用途：javascriptライブラリー「flatpickr 」のインポートと日本語化並びにcodeの記述
-->
@section('scripts')
    @include('share.flatpickr.scripts')
@endsection
