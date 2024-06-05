<?php
require_once("../db_connect_mahjong.php"); ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content px-5">
    <ul>
      <!-- <li><a href="roomDetails.php">基本資料</a></li> -->
      <li><a href="createRoom.php">建立棋牌室</a></li>
      <li><a href="updateBasicInformation.php">更新基本資料</a></li>
      <li><a href="updateTime.php">更新營業時間</a></li>
      <li><a href="createTable.php">桌位管理系統</a></li>
      <li><a href="roomsOverview.php">房間總覽</a></li>
      <li><a href="./dash/sidebar-nav.php">後台管理</a></li>
    </ul>
  </div>
  <?php include("../js-mahjong.php") ?>

</body>

</html>