<?php
require_once("../db_connect_mahjong.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($id == 0 || $room_id == 0) {
    die("無效的桌子 ID 或房間 ID");
}

// 軟刪除指定的桌子
$sql = "UPDATE mahjong_table SET is_deleted = TRUE WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

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
