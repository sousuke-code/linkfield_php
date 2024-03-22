<?php 
session_start();
require('library.php');

//DBからキャンプ場名の取得
$stmt = $pdo->prepare('select place_name from place');
$stmt->execute();
$places = $stmt->fetchAll(PDO::FETCH_COLUMN);



$words = array();


if($_POST['param1']){
  $name = $_POST['param1'];
  foreach($places as $place){
    if(stripos($place, $name) !== false){
      $words[] = $place;
    }
  }
  echo json_encode($words);
}else{
  echo json_encode($words);
}

?>