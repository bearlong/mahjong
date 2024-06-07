<?php
require_once("../db_connect_mahjong.php");

$name = $_POST["name"];
$content = $_POST["content"];
$brand_id = $_POST["brand_id"];
$category_id = $_POST["category_id"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$on_time = $_POST["on_time"];
$off_time = $_POST["off_time"];
$img = $_FILES["img"];

// 處理圖片上傳
$target_dir = "./uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// 去除文件名中的特殊字符和空格
$img_name = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", basename($img["name"]));
$target_file = $target_dir . $img_name;

if (move_uploaded_file($img["tmp_name"], $target_file)) {
    $img_path = $target_file;
} else {
    die("圖片上傳失敗");
}

$sql = "INSERT INTO product (name, content, brand_id, category_id, quantity, price, on_time, off_time, img, create_at) 
        VALUES ('$name', '$content', '$brand_id', '$category_id', '$quantity', '$price', '$on_time', '$off_time', '$img_name', NOW())";

if ($conn->query($sql) === TRUE) {
    header("Location: background.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
