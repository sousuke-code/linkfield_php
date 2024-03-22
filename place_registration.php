<?php
session_start();
require('library.php');

if(!empty($_POST['submitbtn'])){
  if(!empty($_POST['place']) && !empty($_POST['address'])){
    $stmt = $pdo->prepare('insert into place(place_name, address, logo_img) values(:place_name, :address, :logo_img)');
    $stmt->bindParam(':place_name',$_POST['place'],PDO::PARAM_STR);
    $stmt->bindParam(':address',$_POST['address'] ,PDO::PARAM_STR);
    $stmt->bindParam(':logo_img',$_FILES['image']['name'],PDO::PARAM_STR);

    $success = $stmt->execute();

      $fileName = $_FILES['image']['name'];
      $image = $fileName;
      move_uploaded_file($_FILES['image']['tmp_name'], 'logo_images/'.$image);

    header('location:success.php');
    exit;

  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


<h1>施設登録フォーム（管理者）</h1>

<!--　施設の登録フォーム -->
<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">キャンプ場名</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="place">
    
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">住所</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="address">
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">施設写真のアップロード</label>
    <input type="file" class="form-control" id="exampleInputPassword1" name="image">
  </div>


  <input type="submit" class="btn btn-primary" name="submitbtn" value="登録する">
</form>

<a href="place_list.php">登録施設一覧表示</a>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  
</body>
</html>
