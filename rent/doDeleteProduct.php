<?php
require_once("../db_connect_mahjong.php");

if (!isset($_GET["id"])) {
    echo "請於正常管道進入此頁";
    exit;
}

$id = $_GET["id"];

$sql = "UPDATE rent_product SET valid = 0, quantity = 0, quantity_available = 0 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();
header("location: rent-product-list.php");
