<?php
 function h($value) {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

 }
 try{
  $pdo = new PDO('mysql:host=localhost;dbname=bbs_yt', 'root','');
 } catch(PDOExeption $e){
   echo $e->getMessage();
}
?>