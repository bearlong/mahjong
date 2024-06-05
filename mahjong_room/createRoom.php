<?php
require_once("../db_connect_mahjong.php");
?>

<!doctype html>
<html lang="en">

<head>
  <title>create_room</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <?php include("../css-mahjong.php") ?>

</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content px-5">
    <form action="doCreateRoom.php" method="post">
      <div class="row justify-content-center align-items-center g-2 pt-3">
        <div class="col-6 mb-2">
          <label for="" class="form-label">*門店名稱</label>
          <input type="text" class="form-control" name="name">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*電話</label>
          <input type="tele" class="form-control" name="tele">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*門店地址</label>
          <input type="address" class="form-control" name="address">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*統一編號</label>
          <input type="tax_number" class="form-control" name="tax_number">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*營業時間</label>
          <input type="time" class="form-control" name="open_time">
        </div>
        <div class="col-6 mb-2">
          <label for="" class="form-label">*休息時間</label>
          <input type="time" class="form-control" name="close_time">
        </div>

        <button class="col-1 btn btn-primary" type="submit">儲存</button>
      </div>
  </div>


  </form>
  </div>
  </div>



  <?php include("../js-mahjong.php") ?>
</body>

</html>