<?php
require_once("../db_connect_mahjong.php");

session_start();

if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$imgId = $_GET["id"];

$sql = "DELETE FROM `rent_images` WHERE id = $imgId";

$sqlProduct = "SELECT * FROM rent_images WHERE id = $imgId";
$resultProduct = $conn->query($sqlProduct);
$rowProduct = $resultProduct->fetch_assoc();

$path = "../images/rent_product/" . $rowProduct["rent_product_id"] . "/" . $rowProduct["url"];

if (file_exists($path)) {
    unlink($path);
};


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
    header("location: addImg.php?id=" . $rowProduct["rent_product_id"]);
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
