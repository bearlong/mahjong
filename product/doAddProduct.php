<?php
require_once("../db_connect_mahjong.php");

session_start();

if (!isset($_POST["name"])) {
    echo "請於正常管道進入此頁";
    exit;
}

$name = $_POST["name"];
$brand = $_POST["brand"];
$category = $_POST["category"];
$content = $_POST["content"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$now = date('Y-m-d');

if (empty($name)) {
    $_SESSION["errorMsg"] = "請輸入品名";
    header("location: addProduct.php");
    exit;
}

if (empty($content)) {
    $_SESSION["errorMsg"] = "請輸入商品敘述";
    header("location: addProduct.php");
    exit;
} else if (strlen($content) > 1000) {
    $_SESSION["errorMsg"] = "商品敘述不得大於500字";
    header("location: addProduct.php");
    exit;
}

if (empty($quantity)) {
    $_SESSION["errorMsg"] = "請輸入庫存數量";
    header("location: addProduct.php");
    exit;
}

if (empty($price)) {
    $_SESSION["errorMsg"] = "請輸入定價";
    header("location: addProduct.php");
    exit;
}


$sql = "INSERT INTO product (name, brand_id, category_id, content, quantity, price, create_at, on_time) values ('$name', '$brand', '$category', '$content', '$quantity', '$price', '$now', '$now')";

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
    $last_id = $conn->insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    $image = $_FILES["image"];
    $imageName = $image["name"];

    $checkImg = getimagesize($image["tmp_name"]);

    if ($checkImg === false) {
        $_SESSION["errorMsg"] = "上傳的不是圖片";
        header("location: addProduct.php");
        exit;
    }

    if ($image["size"] > 2000000) {
        $_SESSION["errorMsg"] = "圖檔不能大於2MB";
        header("location: addProduct.php");
        exit;
    }

    if (is_uploaded_file($image["tmp_name"])) {
        if (!file_exists("../images/product")) {
            mkdir("../images/product");
        }
        $file = "../images/product/" . basename($imageName);

        if (move_uploaded_file($image["tmp_name"], $file)) {
            // echo "上傳成功";
            unset($_SESSION["errorMsg"]);
            $sqlImg = "UPDATE product SET img = '$imageName' WHERE id = $last_id";

            if ($conn->query($sqlImg) === TRUE) {
            } else {
                echo "Error: " . $sqlImg . "<br>" . $conn->error;
            }
        } else {
            echo "上傳失敗";
        }
    }
} else {
    $_SESSION["errorMsg"] = "請上傳圖片";
    header("location: addProduct.php");
    exit;
}

$conn->close();

header("location: product-list.php");
