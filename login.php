<?php
 session_start();
 require('library.php');

 if(!empty($_POST)){
  if(($_POST['email'] != '') && ($_POST['password'] != '')){
    $login = $pdo->prepare('select * from members where email=?');
    $login->execute(array($_POST['email']));
    $member=$login->fetch();
  
    //認証
    if ($member != false && password_verify($_POST['password'],$member['password'])){
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();
      header('location: index.php');
      exite();
    } else {
      $error['login'] = 'failed';
    }
    } else{
      $error['login'] = 'blank';
    }

 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>ログイン画面</title>
 

  <!-- google icon -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

</head>
<body style="background-color: #f5f5f5;">


  <h1 class="log-head"><span class="material-symbols-outlined" style="font-size:80px;">
groups
</span>
<p>LOGIN</p>
</h1>

  <form method="post" class="login-form">
  <div class="form-group" >
    <label for="exampleInputEmail1">Email </label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo h($_POST['email']??"");?>" name="email">

    <!--エラー表示 -->
    <?php if(isset($error['login']) &&  ($error['login'] =='blank')): ?>
    <small id="emailHelp" class="form-text text-muted">メールアドレスとパスワードを入力してください</small>
    <?php endif; ?>

    <?php if(isset($error['login']) && ($error['login'] == 'failed')):?>
      <small id="emailHelp" class="form-text text-muted">メールアドレスかパスワードが間違っています</small>
    <?php endif ;?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
    value="<?php echo h($_POST['password']??""); ?>" name="password">
  </div>
  <div class="text-center mt-4">
  <input type="submit" class="btn btn-primary " value="ログインする" >
    </div>
  <p class="mt-2">*会員登録がまだお済でない方はこちら</p>
    <a href="registration.php"> ユーザー登録する</a>
</form>



   <!-- bootstrapファイル -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>