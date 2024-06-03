<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_POST["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$category = $_POST["category"];
$content = $_POST["content"];
$quantity = $_POST["quantity"];
$rent_price = $_POST["rent_price"];
$price = $_POST["price"];
$image = $_POST["image"];

$sql = "SELECT * FROM rent_product WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (empty($name)) {
    $_SESSION["errorMsg"] = "請輸入品名";
    header("location: editProduct.php?id=$id");
    exit;
}

if (empty($content)) {
    $_SESSION["errorMsg"] = "請輸入商品敘述";
    header("location: editProduct.php?id=$id");
    exit;
} else if (strlen($content) > 1000) {
    $_SESSION["errorMsg"] = "商品敘述不得大於500字";
    header("location: editProduct.php?id=$id");
    exit;
}

if (empty($quantity)) {
    $_SESSION["errorMsg"] = "庫存數量不得為0";
    header("location: editProduct.php?id=$id");
    exit;
}

if (empty($price)) {
    $_SESSION["errorMsg"] = "請輸入定價";
    header("location: editProduct.php?id=$id");
    exit;
}


if ($row["quantity_available"] == $row["quantity"]) {
    $quantity_available = $quantity;
} else {
    $quantity_available = $quantity - $row["quantity"] + $row["quantity_available"];
}


$now = date('Y-m-d H:i:s');



$sqlEdit = "UPDATE rent_product SET name = '$name', category_id = '$category', content = '$content', img = '$image', quantity = '$quantity', quantity_available = '$quantity_available', rent_price_category_id = '$rent_price', price = '$price', update_at = '$now', valid = 1 WHERE id = $id";

if ($conn->query($sqlEdit) === TRUE) {
    header("location: rent-product.php?id=$id");
} else {
    echo "Error: " . $sqlEdit . "<br>" . $conn->error;
}

$conn->close();
