<?php
require_once("../db_connect_mahjong.php");

$table_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : 0;
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($table_id == 0 || $room_id == 0) {
    die("無效的桌子 ID 或房間 ID");
}

// 軟刪除指定的桌子
$sql = "UPDATE mahjong_table SET is_deleted = TRUE WHERE table_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $table_id);

if ($stmt->execute()) {
    echo "<script>
            alert('桌子刪除成功');
            window.location.href = './roomDetails.php?room_id=$room_id';
          </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
