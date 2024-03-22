<?php
session_start();
require('library.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <title>Document</title>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
<script>
  //オートコンプリート機能
   $(document).ready( function() {
  $("#name").autocomplete({
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
<body>
  <!-- 入力ボックス　-->
  <p><input type="text" id="name"></p>



<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 


</body>
</html>

