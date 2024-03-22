<?php
session_start();
require ('library.php');
date_default_timezone_set('Asia/Tokyo');
$comment_array = array();
$error = [];



//dbから投稿者情報を取得
$members = $pdo->prepare('select * from members where id=?');
$members->execute(array($_SESSION['id']));
$member = $members->fetch();

//DBからコメントデータを取得
  $sql = "SELECT id, username, comment, postDate, fileName0, fileName1, fileName2, place_name FROM bbs_table";
  $comment_array = $pdo->query($sql);


  //データの総件数を取得
  $totalRows = $comment_array->rowCount();

  // 1ページ当たりの表示件数
  $perPage = 5;


  //現在のページ番号を取得
  $page= isset($_GET['page']) ? intval($_GET['page']) : 1;

  //ページ番号の総数を取得
  $totalPages = ceil($totalRows / $perPage);


  //offset と limitを使いページに合わせてコメントを取得
  $offset = ($page -1) * $perPage;
  $sql = "SELECT id, username, comment, postDate, fileName0, fileName1, fileName2, place_name FROM bbs_table LIMIT $offset, $perPage";
  $comment_array = $pdo->query($sql);

$pdo = null;


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP掲示板</title>

  
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <link rel="stylesheet" href="style.css">
  
  <!-- bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

  <!-- フォント -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Galindo&family=Tillana:wght@500;700;800&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
</head>

<body id="post">
  
  <!-- ナビゲーションメニュー-->
  <nav class="navbar  navbar-expand fixed-bottom p-3 justify-content-center" >
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
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

  <h1  class="title" style="margin-left:40px;">link field</h1>

  <hr>
  <div class="boardWrapper">
    <section>
      <!-- 投稿記事生成 -->
      <?php foreach($comment_array as $comment): ?>
    <article class="board">
        <!-- bootstrap -->
      <div class="card" style="width: 100%; bg-white">
       
      <!--プロフィール名 -->
      <div class="card-header bg-white d-flex flex-row align-middle" >
        
        <p class="username me-1">
          <i class="bi bi-person-circle"></i>
            <?php echo $comment['username']; ?>
        </p>

        <p class="place">
        <i class="bi bi-geo-alt-fill"></i>
        <?php echo $comment['place_name']; ?>
        </p>
      </div>

      <!--写真の表示-->
      <div class="d-flex flex-row ">
        <div class="img">
          <a href="images/<?php echo $comment ['fileName0']; ?>"  data-lightbox="photo">
          <img src="images/<?php echo $comment['fileName0']; ?>" class="card-img-top " alt="...">
         </a>
        </div>


        <?php if(!empty($comment['fileName1'])):?>
        <div class="img">
          <a href="images/<?php echo $comment['fileName1']; ?>"  data-lightbox="photo">
          <img src="images/<?php echo $comment['fileName1']; ?>" class="card-img-top  " alt="...">
          </a>
        </div>
        <?php endif; ?>

        <?php if(!empty($comment['fileName2'])): ?>
        <div class="img">
          <a href="images/<?php echo $comment['fileName2']; ?>"  data-lightbox="photo">
          <img src="images/<?php echo $comment['fileName2']; ?>" class="card-img-top  " alt="...">
          </a>
        </div>
        <?php endif; ?>

      </div>

      <div class="card-body">
    
      <p class="card-text"><?php echo $comment['comment']; ?> </p>
    </div>
   </div>
   </article>
    <?php endforeach; ?>
    </section>

    <!--ナビゲーションバーの設定 -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?php if ($i === $page) echo 'active'; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>

    




    <!-- bootstrapファイル -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>