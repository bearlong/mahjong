<?php
require_once("../db_connect_mahjong.php");

$id = $_POST["id"];
$name = $_POST["name"];
$content = $_POST["content"];
$brand_id = $_POST["brand_id"];
$category_id = $_POST["category_id"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$on_time = $_POST["on_time"];
$off_time = $_POST["off_time"];
$img = $_FILES["img"]; // 使用 $_FILES

// 處理圖片上傳
$target_dir = "./uploads/"; // 修改目錄路徑為相對路徑
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($img["name"]);
if (move_uploaded_file($img["tmp_name"], $target_file)) {
    $img_path = basename($img["name"]); // 只儲存檔案名稱到資料庫
} else {
    die("圖片上傳失敗");
}

$sql = "UPDATE product SET 
        name = '$name', 
        content = '$content', 
        brand_id = '$brand_id', 
        category_id = '$category_id', 
        quantity = '$quantity', 
        price = '$price', 
        on_time = '$on_time', 
        off_time = '$off_time', 
        img = '$img_path', 
        update_at = NOW() 
        WHERE id = $id"; // 使用 UPDATE 語句更新資料

if ($conn->query($sql) === TRUE) {
    header("Location: background.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
