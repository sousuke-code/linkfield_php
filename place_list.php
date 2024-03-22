<?php
session_start();
require('library.php');

$sql = "SELECT place_id, place_name, address, logo_img FROM place";
$place_array = $pdo->query($sql);

$pdo = null;


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>





  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
</head>
<body>
  
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">キャンプ場名</th>
      <th scope="col">住所</th>
      <th scope="col">登録写真</th>
    </tr>
  </thead>
  
  <?php foreach($place_array as $place): ?>
    <tbody>
      <tr>
        <th scope="row"><?php echo $place['place_id']; ?></th>
      <td><?php echo $place['place_name'];?></td>
      <td><?php echo $place['address'];?></td>
      <td>
        <a href="logo_images/<?php echo $place['logo_img']; ?>" data-lightbox="place_logo">
        <img src="logo_images/<?php echo $place['logo_img']; ?>" alt="" width="180" height="100" class="zoom"></a></td>
    </tr>
  </tbody>
  <?php endforeach ?>
</table>

<a href="place_registration.php">登録画面に戻る</a>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>