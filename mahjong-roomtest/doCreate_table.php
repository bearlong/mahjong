<?php
require_once("../db_connect.php");

$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$table_type = $_POST["table_type"];
$price = $_POST["price"];
$name = $_POST["name"];
$now = date('Y-m-d H:i:s');
$status = 0;
$is_deleted = 0 ;

if (empty($table_type) || empty($price) || empty($name) || $room_id == 0) {
    echo "所有字段均為必填項。";
    exit;
}

// 檢查 room_id 是否存在於 mahjong_room 表中
$check_room_sql = "SELECT COUNT(*) as count FROM mahjong_room WHERE room_id = ?";
$stmt = $conn->prepare($check_room_sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "錯誤：指定的房間 ID 不存在。";
    exit;
}

$sql = "INSERT INTO mahjong_table (table_type, price, create_at, room_id, status, name,is_deleted)
VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisisss", $table_type, $price, $now, $room_id, $status, $name,$is_deleted);

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
    echo 

    "<script>
            alert('新資料輸入成功, id 為 $last_id');
            window.location.href = 'roomDetails.php?room_id=$room_id';
          </script>";

    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
