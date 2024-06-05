<?php
require_once("../db_connect.php");

// 處理新增或更新麻將房間的請求
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'room') {
    $name = $_POST['name'];
    $tele = $_POST['tele'];
    $address = $_POST['address'];
    $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : null;

    if ($room_id) {
        // 更新房間
        $sql = "UPDATE mahjong_room SET name=?, tele=?, address=? WHERE room_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $tele, $address, $room_id);
    } else {
        // 新增房間
        $sql = "INSERT INTO mahjong_room (name, tele, address) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $tele, $address);
    }

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>房間資訊已成功" . ($room_id ? "更新" : "新增") . "！</div>";
    } else {
        echo "<div class='alert alert-danger'>操作失敗：" . $stmt->error . "</div>";
    }
    $stmt->close();
}

// 處理新增或更新麻將桌的請求
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'table') {
    $name = $_POST['table_name'];
    $price = $_POST['price'];
    $table_type = $_POST['table_type'];
    $status = $_POST['status'];
    $room_id = 2;  // 這裡可以根據需求動態設置
    $table_id = isset($_POST['table_id']) ? $_POST['table_id'] : null;

    if ($table_id) {
        // 更新桌子
        $sql = "UPDATE mahjong_table SET name=?, price=?, table_type=?, status=? WHERE table_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiii", $name, $price, $table_type, $status, $table_id);
    } else {
        // 新增桌子
        $sql = "INSERT INTO mahjong_table (name, price, table_type, status, room_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiii", $name, $price, $table_type, $status, $room_id);
    }

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>桌子資訊已成功" . ($table_id ? "更新" : "新增") . "！</div>";
    } else {
        echo "<div class='alert alert-danger'>操作失敗：" . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麻將房間與桌子管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>麻將房間資訊</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="room">
                <div class="mb-3">
                    <label for="name" class="form-label">商家名稱</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="tele" class="form-label">電話</label>
                    <input type="text" class="form-control" id="tele" name="tele" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">地址</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3>麻將桌資訊</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="table">
                <div class="mb-3">
                    <label for="table_name" class="form-label">名稱</label>
                    <input type="text" class="form-control" id="table_name" name="table_name" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">價格</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="table_type" class="form-label">桌子類型</label>
                    <select class="form-control" id="table_type" name="table_type" required>
                        <option value="0">大廳</option>
                        <option value="1">包廂</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">狀態</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="0">空閒中</option>
                        <option value="1">不可用</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
