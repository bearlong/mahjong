<?php
session_start();
require_once("../db_connect_mahjong.php");

$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id > 0) {
    $sql = "UPDATE mahjong_room SET is_deleted = 1 WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "房間刪除成功";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "房間刪除失敗";
        $_SESSION['message_type'] = "danger";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "無效的房間 ID";
    $_SESSION['message_type'] = "danger";
}

$conn->close();
header("Location: allRooms.php");
exit;
