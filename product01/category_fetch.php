<?php
require_once("../db_connect_mahjong.php");

// 獲取所有類別
$sqlCategory = "SELECT * FROM product_category ORDER BY id ASC";
$resultCate = $conn->query($sqlCategory);

if ($resultCate) {
    $cateRows = $resultCate->fetch_all(MYSQLI_ASSOC);
} else {
    $cateRows = [];
}
