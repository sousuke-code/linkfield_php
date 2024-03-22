<?php
session_start();
require('library.php');
var_dump($_SESSION);
if (!isset($_SESSION['join'])){
  header('location:registration.php');
  exit();
}
$hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
if (!empty($_POST)){
  $stmt = $pdo->prepare('insert into members  (username, email, password, created) VALUES (?, ?, ?, NOW())');
   $stmt->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    $hash
  ));
  $_SESSION['id'] = $pdo->lastINsertID();
  unset($_SESSION['join']);
  header('location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" >
  <title>ユーザー登録確認画面</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
</head>
<body style="background-color: #f5f5f5;">

<h1 class="log-head"><span class="material-symbols-outlined" style="font-size:80px;">
groups
</span>
<p>REGISTER</p>
</h1>

<form method="post" class="confirm-form">
  <div class="mb-2">
  <label class="form-label" for="name">お名前</label>
  <input class="form-control" type="text" name="password" id="name"
    value="<?php echo h($_SESSION['join']['name']);?>" disabled >
  </div>
  <div class="mb-2">
  <label class="form-label" for="name">email</label>
  <input class="form-control" type="text" name="email" id="address"
    value="<?php echo h($_SESSION['join']['email']);?>" disabled>
  </div>
  <a href="registration.php">
        <input type="button"value="修正する" class="btn btn-primary" class="button02" onclick="location.href='index.html'">
      </a>
        <input type="submit" value="登録する" name="registration" class="btn btn-primary" onclick="location.href='index.html'">
      
</form>

<!--
  <div style="background-color: #f5f5f5;">
    <h1>ユーザー登録確認画面</h1>
    <form action="" method="post">
      <p>
        名前:
        <span><?php echo h($_SESSION['join']['name']); ?></span>
      </p>
      <p>
        email:
        <span><?php echo h($_SESSION['join']['email']); ?></span>
      </p>
      <p>
        パスワード:
        <span>[セキュリティのため非表示]</span>
      </p>
      <a href="registration.php">
        <input type="button"value="修正する" name="rewrite" class="button02">
      </a>
      <a href="index.php">
        <input type="submit" value="登録する" name="registration" class="button">
      </a>
    </form>
  </div>
-->
  

 <!-- bootstrapファイル -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>