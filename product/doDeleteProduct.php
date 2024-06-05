<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_GET["id"];

$now = date("Y-m-d");

$sql = "UPDATE `product` SET `quantity` = 0,  `off_time` = '$now' WHERE `product`.`id` = $id";

if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("location: product-list.php?id=$id");
