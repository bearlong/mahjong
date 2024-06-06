<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_GET["id"];


$sql = "UPDATE `brand` SET `valid` = 0 WHERE `brand`.`id` = $id";

if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("location: addBrand.php");
