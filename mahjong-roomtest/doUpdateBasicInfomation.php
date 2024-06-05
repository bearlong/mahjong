<?php
require_once("../db_connect.php");

// 获取URL中的room_id参数
$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;

// 验证room_id是否有效
if ($room_id <= 0) {
    die("<div class='container mt-5'><div class='alert alert-danger'>无效的房间ID</div></div>");
}

$tele = $_POST["tele"];
$address = $_POST["address"];
$tax_number = $_POST["tax_number"];

// 准备SQL语句
$sql = "UPDATE mahjong_room SET 
tele=?,
address=?
WHERE room_id=?";

// 使用预处理语句
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $tele, $address, $room_id);

// 执行SQL查询
if ($stmt->execute()) {
    echo
    "<script>
    alert('新資料輸入成功');
    window.location.href = 'roomDetails.php?room_id=$room_id';
  </script>";
    exit();
} else {
    echo "更新資料錯誤: " . $conn->error;
}

// 关闭预处理语句和数据库连接
$stmt->close();
$conn->close();
