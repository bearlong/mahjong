<?php
require_once("../db_connect_mahjong.php");

// 获取URL中的room_id参数
$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;

// 验证room_id是否有效
if ($room_id <= 0) {
    die("<div class='container mt-5'><div class='alert alert-danger'>无效的房间ID_time</div></div>");
}

$open_time = $_POST["open_time"];
$close_time = $_POST["close_time"];

$sql = "UPDATE mahjong_room SET close_time=?, open_time=? WHERE room_id=?";

// 使用预处理语句
$stmt = $conn->prepare($sql);

// 確認參數綁定的類型是正確的
$stmt->bind_param("ssi", $close_time, $open_time, $room_id);

// 執行SQL查詢
if ($stmt->execute()) {
    header("Location: roomDetails.php?room_id=$room_id&status=success");
} else {
    header("Location: roomDetails.php?room_id=$room_id&status=error");
}

// 关闭预处理语句和数据库连接
$stmt->close();
$conn->close();
