<?php
require_once("../db_connect_mahjong.php");



$open_time = $_POST["open_time"];
$close_time = $_POST["close_time"];


$sql = "UPDATE mahjong_room SET 
close_time='$close_time', open_time='$open_time' 
WHERE room_id=2";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
    header("location: index.php");
} else {
    echo "更新資料錯誤: " . $conn->error;
}

$conn->close();
