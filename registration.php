<?php
session_start();
require('library.php');
$error = [];
//エラーチェック
if (!empty($_POST)){
  if($_POST['name'] == ""){
    $error['name'] = 'blank';
  }
  if($_POST['email'] == ""){
    $error['email'] = 'blank';
  }else {
    $member = $pdo->prepare('select count(*) as cnt from members where email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if($record['cnt'] > 0){
      $error['email'] = 'duplicate';
    }
  }
  if($_POST['password'] == ""){
    $error['password'] ='blank';
  }
  if($_POST['password2'] == ""){
    $error['password2'] = 'blank';
  }
  if(strlen($_POST['password']) < 6){
    $error['password'] = 'length';
  }
  if(($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")){
    $error['password2'] = 'difference';
  }
  if(empty($error)) {
    $_SESSION['join'] = $_POST;
    var_dump($_SESSION);
    header('location: confirm.php');
    exit();
  }
}
if (isset($_SESSION['join']) && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'rewrite')) {
  $_POST = $_SESSION['join'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" >
  <title>Document</title>


  <!-- google icon -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


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


<form action="" method="post" class="register-form">
  <div class="mb-2">
    <label class="form-label" for="name">お名前</label>
    <input class="form-control" type="text" name="name" id="name"
    value="<?php echo $_POST['name']??"";?>" >
    <?php if(isset($error['name']) && ($error['name'] == 'blank')):?>
      <small id="emailHelp" class="form-text text-muted">名前を入力してください</small>
    <?php endif; ?>
  </div>

  <div class="mb-2">
    <label class="form-label" for="address">メールアドレス</label>
    <input class="form-control" type="email" name="email" id="address"value="<?php echo $_POST['email']??"";?>">
    <?php if (isset($error['email']) && ($error['email'] == 'blank')): ?>
      <small id="emailHelp" class="form-text text-muted">メールアドレスを入力してください</small>
    <?php endif; ?>
    <?php if(isset($error['email']) && ($error['email'] == "duplicated")): ?>
      <small id="emailHelp" class="form-text text-muted">そのメールアドレスは既に登録されています</small>
    <?php endif; ?>
  </div>

  <div class="mb-2">
    <label class="form-label" for="name">パスワード</label>
    <input class="form-control" type="password" name="password" id="password"
    value="<?php echo $_POST['password']??"";?>" >
    <?php if(isset($error['password']) && ($error['password'] == "blank")): ?>
      <small id="emailHelp" class="form-text text-muted">パスワードを入力してください</small>
    <?php endif; ?>

    <?php if(isset($error['password']) && ($error['password'] == "length")): ?>
      <small id="emailHelp" class="form-text text-muted">6文字以上で入力してください</small>
    <?php endif; ?>
  </div>

  <div class="mb-2">
    <label class="form-label" for="name">パスワード再入力</label>
    <input class="form-control" type="password" name="password2" id="name">
    <?php if(isset($error['password2']) && ($error['password2'] == "blank")):?>
      <small id="emailHelp" class="form-text text-muted">パスワードを入力してください</small>
    <?php endif; ?>

    <?php if(isset($error['password2']) && ($error['password2']== "different")): ?>
      <small id="emailHelp" class="form-text text-muted">パスワードが異なります</small>
    <?php endif; ?>
  </div>

  <div class="text-center mt-4">
    <input type="submit" class="btn btn-primary" value="登録する">
  </div>
</form>
  

  
   <!-- bootstrapファイル -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>