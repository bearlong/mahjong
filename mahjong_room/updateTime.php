<?php
require_once("../db_connect_mahjong.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>update</title>
  <?php include("../css-mahjong.php"); ?>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content row">
    <form action="doUpdateTime.php" method="post">
      <div class="col-6 mb-2">
        <label for="" class="form-label">*營業時間</label>
        <input type="time" class="form-control" name="open_time">
      </div>
      <div class="col-6 mb-2">
        <label for="" class="form-label">*休息時間</label>
        <input type="time" class="form-control" name="close_time">
      </div>

      <button class="col-1 btn btn-primary" type="submit">更新</button>
    </form>
  </div>
  <?php include("../js-mahjong.php") ?>

</body>

</html>