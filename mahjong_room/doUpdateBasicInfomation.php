<?php
require_once("../db_connect_mahjong.php");


$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;

// 验证room_id是否有效
if ($room_id <= 0) {
    header("Location: roomDetails.php?room_id=$room_id&status=error");
    exit();
}

$name = $_POST["name"];
$tele = $_POST["tele"];
$address = $_POST["address"];
$tax_number = $_POST["tax_number"];

// 准备SQL语句
$sql = "UPDATE mahjong_room SET name=?, tele=?, address=? WHERE room_id=?";

// 使用预处理语句
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $name, $tele, $address, $room_id);

// 执行SQL查询
if ($stmt->execute()) {
    header("Location: roomDetails.php?room_id=$room_id&status=success");
} else {
    header("Location: roomDetails.php?room_id=$room_id&status=error");
}

// 关闭预处理语句和数据库连接
$stmt->close();
$conn->close();
exit();
