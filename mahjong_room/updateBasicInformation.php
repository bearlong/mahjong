<?php
require_once("../db_connect_mahjong.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>updateBasicInformation</title>
  <?php include("../css-mahjong.php"); ?>

</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content">
    <form action="updateBasicInformation.php" method="post">
      <div class="row justify-content-center align-items-center g-2">

        <div class="col-6 mb-2">
          <label for="" class="form-label">*電話</label>
          <input type="tele" class="form-control" name="tele">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*門店地址</label>
          <input type="address" class="form-control" name="address">
        </div>

        <button class="col-1 btn btn-primary" type="submit">更新</button>
      </div>


  </div>

  </form>
  <?php include("../js-mahjong.php") ?>

</body>

</html>