<?php
require_once("../db_connect_mahjong.php");

$name = $_POST["name"];
$tele = $_POST["tele"];
$address = $_POST["address"];
$tax_number = $_POST["tax_number"];



$sql = "UPDATE mahjong_room SET 
tele='$tele',
address='$address',
WHERE room_id=2";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
    header("location: index.php");
} else {
    echo "更新資料錯誤: " . $conn->error;
}

$conn->close();
