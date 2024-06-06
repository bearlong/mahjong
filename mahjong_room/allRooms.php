<?php
session_start();
require_once("../db_connect_mahjong.php");

// 每頁顯示的資料數量
$records_per_page = 15;

// 獲取當前頁數，默認為第1頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

// 搜尋功能
$search = isset($_GET['search']) ? $_GET['search'] : '';

$owner = "";

if (isset($_GET["owner"])) {
  $owner_id = $_GET["owner"];
  $owner = "AND mahjong_room.owner_id=" . $owner_id;
}

// 計算總記錄數，忽略已刪除的資料
$sql_total = "SELECT COUNT(*) AS total FROM mahjong_room WHERE is_deleted = 0 $owner AND name LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$search_param = "%" . $search . "%";
$stmt_total->bind_param("s", $search_param);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_records = $result_total->fetch_assoc()['total'];
$stmt_total->close();

// 計算總頁數
$total_pages = ceil($total_records / $records_per_page);

// 計算當前頁的起始記錄索引
$start_from = ($page - 1) * $records_per_page;

// 查詢當前頁的記錄
$sql = "SELECT mahjong_room.*, owner.company_name FROM mahjong_room JOIN owner ON mahjong_room.owner_id = owner.id WHERE is_deleted = 0 $owner AND name LIKE ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $search_param, $start_from, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();
$rooms = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>房間總覽</title>
  <?php include("../css-mahjong.php") ?>
  <style>
    .table-hover tbody tr:hover {
      transform: scale(1.01);
      transition: transform 0.2s;
    }

    .table-responsive {
      overflow-x: hidden;
    }
  </style>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content px-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-center">房間總覽</h1>
      <?php if (isset($_GET["search"]) || isset($_GET["owner"])) : ?>
        <div>
          <a href="allRooms.php" class="btn btn-primary">返回首頁</a>
        </div>
      <?php endif; ?>
    </div>
    <?php if (isset($_SESSION['message'])) : ?>
      <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['message']);
      unset($_SESSION['message_type']); ?>
    <?php endif; ?>
    <form method="get" class="mb-4 d-flex justify-content-between gap-3">
      <div class="input-group position-relative z-0">
        <input type="text" class="form-control" name="search" placeholder="搜尋房間名稱" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">搜尋</button>
        <a href="?" class="btn btn-secondary">重置搜尋</a>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>名稱</th>
            <!-- <th>地址</th> -->
            <th>所屬公司</th>
            <th>刪除</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($rooms)) : ?>
            <?php foreach ($rooms as $room) : ?>
              <tr>
                <td><?= htmlspecialchars($room["room_id"]) ?></td>
                <td><?= htmlspecialchars($room["name"]) ?></td>
                <td><a class="text-decoration-none" href="?page=1&owner=<?= $room["owner_id"] ?>"><?= htmlspecialchars($room["company_name"]) ?></a></td>
                <!-- <td><?= htmlspecialchars($room["close_time"]) ?></td> -->
                <td><a href="deleteRoom.php?room_id=<?= htmlspecialchars($room['room_id']) ?>" class="btn btn-danger">刪除</a></td>
                <td><a href="roomDetails.php?room_id=<?= htmlspecialchars($room['room_id']) ?>" class="btn btn-primary">查看詳情</a></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="5" class="text-center">沒有找到任何房間</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- 分頁導航 -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
          <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $page - 1; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $i; ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
          <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&page=<?= $page + 1; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <?php include("../js-mahjong.php") ?>

</body>

</html>