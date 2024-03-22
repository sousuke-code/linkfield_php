<?php

// ファイルがあれば処理実行
if(isset($_FILES["upload_file"])){

    // アップロードされたファイル件を処理
    foreach($_FILES["upload_file"]["tmp_name"] as $key => $tmp_name) {

        // アップロードされたファイルか検査
        if(is_uploaded_file($tmp_name)){

            // ファイル名を一意にするためにランダムな文字列を使用
            $random_string = bin2hex(random_bytes(8)); // 8 バイトのランダムな文字列を生成
            $extension = pathinfo($_FILES["upload_file"]["name"][$key], PATHINFO_EXTENSION);
            $new_filename = $random_string . '.' . $extension;

            // ファイルをお好みの場所に移動
            move_uploaded_file($tmp_name, "./testimages/" . $new_filename);
        }
    }
}

?>


<html>

<head>
    <meta charset="utf-8">
    <title>ふぁいるあっぷろーどする</title>
</head>
<body>
    <form action="./" method="post" enctype="multipart/form-data">
        <input type="file" multiple name="upload_file[]" />
        <input type="submit" value="そうしん！" />
    </form>
</body>