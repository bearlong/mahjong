<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_POST["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$brand = $_POST["brand"];
$category = $_POST["category"];
$content = $_POST["content"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$image = $_FILES["image"];
$now = date("Y-m-d");


$sqlImg = "SELECT img FROM product WHERE id = $id";
$resultImg = $conn->query($sqlImg);
$rowImg = $resultImg->fetch_assoc();


if (empty($name)) {
    $_SESSION["errorMsg"] = "請輸入品名";
    header("location:./editProduct.php?id=$id");
    exit;
}

if (empty($content)) {
    $_SESSION["errorMsg"] = "請輸入商品敘述";
    header("location:./editProduct.php?id=$id");
    exit;
}

if (empty($quantity) || $quantity === 0) {
    $_SESSION["errorMsg"] = "請輸入庫存數量";
    header("location:./editProduct.php?id=$id");
    exit;
}

if (empty($price)) {
    $_SESSION["errorMsg"] = "請輸入價錢";
    header("location:./editProduct.php?id=$id");
    exit;
}

if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    $image = $_FILES["image"];
    $imageName = $image["name"];

    $checkImg = getimagesize($image["tmp_name"]);

    if ($checkImg === false) {
        $_SESSION["errorMsg"] = "上傳的不是圖片";
        header("location: editProduct.php?id=$id");
        exit;
    }

    if ($image["size"] > 2000000) {
        $_SESSION["errorMsg"] = "圖檔不能大於2MB";
        header("location: editProduct.php?id=$id");
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
            $path = "../images/product/" . $rowImg["img"];

            if (file_exists($path)) {
                unlink($path);
            };


            $sql = "UPDATE `product` SET `name` = '$name', `brand_id` = '$brand', `category_id` = '$category', `content` = '$content', `quantity` = '$quantity', `price` = '$price', img = '$imageName',`off_time` = NULL, `update_at` = '$now' WHERE `product`.`id` = $id";

            if ($conn->query($sql) === TRUE) {
            } else {
                $_SESSION["errorMsg"] = "刪除圖片錯誤";
                header("location: editProduct.php?id=$id");
                exit;
            }
        } else {
            echo "上傳失敗";
        }
    }
} else {
    unset($_SESSION["errorMsg"]);
    $sql = "UPDATE `product` SET `name` = '$name', `brand_id` = '$brand', `category_id` = '$category', `content` = '$content', `quantity` = '$quantity', `price` = '$price', `off_time` = NULL, `update_at` = '$now' WHERE `product`.`id` = $id";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

header("location: product.php?id=$id");
