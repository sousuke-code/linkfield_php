<?php
session_start();
require('library.php');
$countfiles=0;


//membersテーブルから情報を取得
$members = $pdo->prepare('select * from members where id=?');
$members->execute(array($_SESSION['id']));
$member = $members->fetch();


if(isset($_FILES['image'])){
  $new_files = $_FILES['image'];
for($i=0;$i< count($new_files['tmp_name']);$i++){
  if(!empty($new_files['tmp_name'][$i])){
    $fileName[$i]= $new_files['name'][$i];
    move_uploaded_file($new_files['tmp_name'][$i],'images/'.$fileName[$i]);
   }
 }
} 

//フォームを打ち込んだ時
if (!empty($_POST['submitbtn'])) {
  if(isset($_POST['comment']) && count($fileName) < 4){
    $postDate = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('insert into bbs_table (username, comment, postDate, fileName0, fileName1, fileName2, place_name) values(:username, :comment, :postDate, :fileName0, :fileName1, :fileName2, :place_name)');
    $stmt->bindParam(':username',$member['username'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $_POST['comment'],PDO::PARAM_STR);
    $stmt->bindParam(':postDate', $postDate,PDO::PARAM_STR);

    //画像ファイルの保存
    for($i = 0; $i < 3; $i++){
      $fileName[$i] = isset($fileName[$i]) ? $fileName[$i] : ""; // ファイルがアップロードされていない場合は空文字をセットする
      $stmt->bindParam(":fileName$i", $fileName[$i], PDO::PARAM_STR);
      
    }
    $stmt->bindParam(':place_name', $_POST['place_name'],PDO::PARAM_STR);
    
    //画像取得後フォルダに保存
    $success = $stmt->execute();
      header('location: index.php');
     exit;
     
    }else{
     $error['comment'] = 'blank';
       }
       if(count($fileName) > 3){
        $error['image'] = 'much';
       }
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>

  <script>
  //オートコンプリート機能
   $(document).ready( function() {
  $("#place_name").autocomplete({
    source: function(req, resp){
        $.ajax({
            url: "autocomplete.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: {
            param1: req.term
            },
            success: function(o){
            resp(o);
            },
            error: function(xhr, ts, err){
            resp(['']);
            }
        });
    }
  });
});
</script>

</head>
<body id="post">

<nav class="navbar  navbar-expand fixed-bottom p-3 justify-content-center "  >
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
        <a class="nav-link" href="post.php">
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


<!--bootstrap -->
<form class="formWrapper" method="post" enctype="multipart/form-data">
  <!-- 名前の保存 -->
  <div class="mb-2">
    <label class="form-label" for="name">お名前</label>
    <input class="form-control" type="text" name="name" id="name"
    value="<?php echo h($member['username']);?> " 
    style="bg-white"
    disabled>
  </div>

  <!-- 場所の選択 -->
  <div class="mb-2">
    <label class="form-label" for="name">キャンプ場検索</label>
    <input class="form-control" type="text" name="place_name" id="place_name"
    >
  </div>


 <!-- 写真の追加 -->
 <div class="imagepreview" id="preview"></div>
<div class="input-group">
    <label class="input-group-btn">
        <span class="btn btn-primary">
            写真を追加する<input type="file" name="image[]" onchange="preview(this)"  multiple 
            style="display:none" id="image">        
          </span>
          <?php if(isset($error) && $error['image'] === 'much'): ?>
     <p class="help-block">*写真は三枚まで選択できます</p>
     <?php endif ;?>
        </label>
    
</div>
    

  <!-- 投稿内容 -->
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label"></label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" name="comment" placeholder="キャンプ場の感想などを記入してみましょう!"></textarea>
  </div>
  
  <input type="submit" class="btn btn-primary justify-center" name="submitbtn" value="投稿する" id="submit">

  <?php if(isset($error) && $error['comment'] === 'blank'): ?>
  <p class="help-block">※記事内容を記入してください</p>
  <?php endif ;?>

</form>



  <!-- jquery ファイル -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 


  <!-- bootstrapファイル -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

 <!-- 画像のプレヴュー表示 -->
 
 <script>
  
 function preview(o) {
    const preview = document.getElementById('preview');
    /*
    const fileReader = new FileReader();
    fileReader.onload = (function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        preview.appendChild(img);
    });
    fileReader.readAsDataURL(o.files[0]);
    */
    // ファイルをループ処理してプレビューを追加する
    for (let i = 0; i < o.files.length; i++) {
        const fileReader = new FileReader();
        fileReader.onload = (function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        });
        fileReader.readAsDataURL(o.files[i]);
    }
}




var fileList = [];
$('input#image').change(function(){
    var testfile = document.getElementById("image");
    var files = $(this).prop('files');
    const dt = new DataTransfer();

    for (var i = 0; i < fileList.length; i++){
      dt.items.add(fileList[i]);
    }
    for (var i = 0; i < files.length; i++){
      dt.items.add(files[i]);
      fileList.push(files[i]);
    }
    testfile.files = dt.files;
})
</script>


</body>
</html>