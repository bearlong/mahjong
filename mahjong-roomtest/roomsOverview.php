<?php
require_once("../db_connect.php");

// 查詢所有房間資料
$sql = "SELECT * FROM mahjong_room";
$result = $conn->query($sql);
$rooms = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>房間總覽</title>
  <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
  />
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
    .card-link {
      text-decoration: none;
      color: inherit;
    }
    .card-link:hover {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-center">房間總覽</h1>
      <a href="index.php" class="btn btn-primary">返回首頁</a>
    </div>
    <div class="row">
      <?php if (!empty($rooms)): ?>
        <?php foreach ($rooms as $room): ?>
          <div class="col-md-4 mb-4 d-flex">
            <a href="roomDetails.php?room_id=<?= htmlspecialchars($room['room_id']) ?>" class="card-link w-100">
              <div class="card w-100">
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($room["name"]) ?></h5>
                  <p class="card-text"><strong>電話:</strong> <?= htmlspecialchars($room["tele"]) ?></p>
                  <p class="card-text"><strong>地址:</strong> <?= htmlspecialchars($room["address"]) ?></p>
                  <p class="card-text"><strong>營業時間:</strong> <?= htmlspecialchars($room["open_time"]) ?></p>
                  <p class="card-text"><strong>休息時間:</strong> <?= htmlspecialchars($room["close_time"]) ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <p class="text-center">沒有找到任何房間</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
