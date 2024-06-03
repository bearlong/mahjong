<?php
require_once("../db_connect_mahjong.php");
session_start();
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>房間總覽</title>
  <?php include("../css-mahjong.php") ?>
  <style>
    .card:hover {
      transform: scale(1.05);
      transition: transform 0.2s;
    }

    .card {
      height: 100%;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  </style>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container pt-5 main-content">
    <h1 class="text-center pt-3">房間總覽</h1>
    <a href="list.php" class="btn btn-primary">返回首頁</a>

    <div class="row">
      <?php
      $sql = "SELECT * FROM mahjong_room";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-md-4 mb-4 d-flex">';
          echo '<div class="card w-100">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row["name"] . '</h5>';
          echo '<p class="card-text"><strong>電話:</strong> ' . $row["tele"] . '</p>';
          echo '<p class="card-text"><strong>地址:</strong> ' . $row["address"] . '</p>';
          echo '<p class="card-text"><strong>營業時間:</strong> ' . $row["open_time"] . '</p>';
          echo '<p class="card-text"><strong>休息時間:</strong> ' . $row["close_time"] . '</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<div class="col-12">';
        echo '<p class="text-center">沒有找到任何房間</p>';
        echo '</div>';
      }
      $conn->close();
      ?>
    </div>
  </div>

  <?php include("../js-mahjong.php") ?>
</body>

</html>