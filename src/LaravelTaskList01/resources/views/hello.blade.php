<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My First Page</title>
</head>
<body>
    <!-- <h2>Hello World</h2> -->
    <h1>Laravel ENV FILE</h1>
    <p>{{ env('DB_CONNECTION')}}</p>
    <p>{{ config('database.default') }}</p>
    <p>{{ env('EXAMPLE_APP_KEY')}}</p>
    <p>{{ config('example.key')}}</p>


    <?php

        if (App::environment('local')) {
            // 環境がlocal(開発）の場合
            echo "開発環境です";
        }elseif(App::environment('production')) {
            // 環境がproduction(本番）の場合
            echo "本番環境です";
        }else{
            // その他の環境
            echo "その他の環境です";
        }

    ?>

</body>
</html>
