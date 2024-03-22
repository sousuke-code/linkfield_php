<?php
session_start();
require('library.php');
$error = [];

//dbから投稿者情報を取得
$members = $pdo->prepare('select * from members where id=?');
$members->execute(array($_SESSION['id']));
$member = $members->fetch();

$sql = "SELECT id, username, comment, postDate, fileName0, fileName1, fileName2, place_name FROM bbs_table WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($member['username']));
$comment_array = $stmt->fetchAll();



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <link rel="stylesheet" href="style.css">

  <!-- bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">


</head>
<body id="post">

<!-- ナビゲーションメニュー-->
<nav class="navbar  navbar-expand fixed-bottom p-3 justify-content-center" >
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-center h-25"
   id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

     <li class="nav-item active me-2" >
        <a class="nav-link" href="index.php">
        <i class="bi bi-house"></i>Home
        <span class="sr-only"></span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="post2.php">
        <i class="bi bi-pencil-square"></i>
        投稿する</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="my_page.php">
        <i class="bi bi-person-square"></i>
        マイページ</a>
      </li>

      

    </ul>
  </div>
</nav>

<!-- プロフィール欄 -->
<div class="container justify-content-center " style="height: 80px;">
<h3><i class="bi bi-person-circle m-3"><?php echo $member['username'] ;?>の記録</i>
<a href="login.php" class="btn btn-outline-dark btn-sm m-3">ログアウトする</a>
</h3>
</div>


<!-- 登録アカウントの投稿記事一覧 -->

<div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
<?php foreach ($comment_array as $comment):?>
  
    <div class="card p-0 mb-3" style="width: 18rem;">
          <img src="images/<?php echo $comment['fileName0'];  ?>" class="card-img-top " alt="...">
          <h5 class="card-header"><?php echo $comment['place_name'] ?></h5>
          <div class="card-body">
          <p class="card-text"><?php echo $comment['comment']; ?></p>
          
        </div>
      </div> 
      <?php endforeach; ?>
    </div>


   <!-- bootstrapファイル -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>