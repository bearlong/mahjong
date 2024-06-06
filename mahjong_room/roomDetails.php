<?php
require_once("../db_connect_mahjong.php");
session_start();


// 獲取URL中的room_id參數
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// 驗證room_id是否有效
if ($room_id <= 0) {
    die("<div class='container mt-5'><div class='alert alert-danger'>無效的房間ID</div></div>");
}

// 查詢麻將房間資訊
$sql1 = "SELECT * FROM mahjong_room WHERE room_id = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $room_id);
$stmt1->execute();
$result1 = $stmt1->get_result();

// 如果查無此房間，顯示錯誤信息
if ($result1->num_rows === 0) {
    $stmt1->close();
    $conn->close();
    die("<div class='container mt-5'><div class='alert alert-warning'>查無資料</div></div>");
}

// 獲取篩選條件
$price_min = isset($_GET['price_min']) ? intval($_GET['price_min']) : 0;
$price_max = isset($_GET['price_max']) ? intval($_GET['price_max']) : 10000;
$table_type = isset($_GET['table_type']) ? intval($_GET['table_type']) : -1;
$status = isset($_GET['status']) ? intval($_GET['status']) : -1;

$sqlOwner = "SELECT mahjong_room.*, owner.company_name FROM mahjong_room JOIN owner ON mahjong_room.owner_id = owner.id WHERE mahjong_room.room_id = $room_id ";
$resultOwner = $conn->query($sqlOwner);
$owner = $resultOwner->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麻將房間資訊</title>
    <style>
        .fade-out {
            animation: fadeOut 1s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                max-height: 100px;
                padding: 0.75rem 1.25rem;
                margin-bottom: 1rem;
            }

            to {
                opacity: 0;
                max-height: 0;
                padding: 0;
                margin-bottom: 0;
            }
        }
    </style>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php") ?>

    <div class="container main-content px-5">
        <div class="btn-group my-2">
            <a class="btn btn-primary" href="userRoomsOverview.php">回門店總覽</a>
            <a href="allRooms.php" class="btn btn-primary">返回後台</a>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
            <div class="alert alert-success auto-dismiss" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                更新成功！
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error') : ?>
            <div class="alert alert-danger auto-dismiss" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>

                更新失敗，請重試。
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3><?= $owner["company_name"] ?>-棋牌室資訊</h3>
                <div class="btn-group">
                    <a class="btn btn-primary" href="updateBasicInformation.php?room_id=<?php echo $room_id; ?>">修改門店資料</a>
                    <a class="btn btn-primary" href="updateTime.php?room_id=<?php echo $room_id; ?>">修改營業時間</a>
                </div>
            </div>
            <div class="card-body">
                <?php
                while ($row1 = $result1->fetch_assoc()) {
                    echo "<p><strong>商家:</strong> " . htmlspecialchars($row1["name"]) . "</p>";
                    echo "<p><strong>電話:</strong> " . htmlspecialchars($row1["tele"]) . "</p>";
                    echo "<p><strong>地址:</strong> " . htmlspecialchars($row1["address"]) . "</p>";
                    echo "<p><strong>營業時間:</strong> " . htmlspecialchars(date('H:i', strtotime($row1["open_time"]))) . "</p>";
                    echo "<p><strong>營業時間:</strong> " . htmlspecialchars(date('H:i', strtotime($row1["close_time"]))) . "</p>";
                }
                $stmt1->close();
                ?>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>麻將桌</h3>
                <div class="btn-group">
                    <a class="btn btn-primary" href="createTable.php?room_id=<?php echo $room_id; ?>">增加桌/廳</a>
                </div>
            </div>
            <div class="card-body">
                <form class="row mb-4" method="GET" action="">
                    <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                    <div class="col-md-3">
                        <label for="price_min" class="form-label">最低價格</label>
                        <input type="number" class="form-control" name="price_min" value="<?php echo $price_min; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="price_max" class="form-label">最高價格</label>
                        <input type="number" class="form-control" name="price_max" value="<?php echo $price_max; ?>" min="0" max="10000">
                    </div>
                    <div class="col-md-3">
                        <label for="table_type" class="form-label">類型</label>
                        <select class="form-select" name="table_type">
                            <option value="-1" <?php if ($table_type == -1) echo 'selected'; ?>>所有</option>
                            <option value="1" <?php if ($table_type == 1) echo 'selected'; ?>>大廳</option>
                            <option value="0" <?php if ($table_type == 0) echo 'selected'; ?>>包廂</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">狀態</label>
                        <select class="form-select" name="status">
                            <option value="-1" <?php if ($status == -1) echo 'selected'; ?>>所有</option>
                            <option value="0" <?php if ($status == 0) echo 'selected'; ?>>空閒中</option>
                            <option value="1" <?php if ($status == 1) echo 'selected'; ?>>不可用</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-2">
                        <button type="submit" class="btn btn-primary">篩選</button>
                    </div>
                </form>
                <?php
                // 查詢麻將桌資訊，根據篩選條件進行篩選
                $sql2 = "SELECT * FROM mahjong_table WHERE room_id = ? AND is_deleted = FALSE AND price BETWEEN ? AND ?";
                $params = [$room_id, $price_min, $price_max];

                if ($table_type != -1) {
                    $sql2 .= " AND table_type = ?";
                    $params[] = $table_type;
                }

                if ($status != -1) {
                    $sql2 .= " AND status = ?";
                    $params[] = $status;
                }

                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param(str_repeat('i', count($params)), ...$params);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                if ($result2->num_rows > 0) {
                    echo "<table class='table table-striped'>";
                    echo "<thead><tr><th>名稱</th><th>價格</th><th>桌子類型</th><th>狀態</th><th>操作</th></tr></thead><tbody>";
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row2["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row2["price"]) . "</td>";
                        echo "<td>" . ($row2["table_type"] == 1 ? "大廳" : "包廂") . "</td>";
                        echo "<td>" . ($row2["status"] == 0 ? "空閒中" : "不可用") . "</td>";
                        echo "<td><a href='deleteTable.php?table_id=" . $row2["table_id"] . "&room_id=" . $room_id . "' class='btn btn-danger btn-sm' onclick='return confirm(\"確認刪除這個桌子嗎？\");'>刪除</a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p class='text-warning'>查無資料</p>";
                }
                $stmt2->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <?php include("../js-mahjong.php") ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.auto-dismiss');
                alerts.forEach(function(alert) {
                    alert.classList.add('fade-out');
                });
            }, 2000); // 2秒後觸發動畫
            setTimeout(function() {
                var alerts = document.querySelectorAll('.auto-dismiss');
                alerts.forEach(function(alert) {
                    alert.style.display = 'none';
                });
                var url = new URL(window.location);
                url.searchParams.delete('status');
                history.replaceState(null, '', url.toString());
            }, 3000); // 3秒後隱藏並清理URL
        });
    </script>

</body>

</html>