<?php
require_once("../db_connect_mahjong.php");

if (!isset($_POST["name"])) {
    echo "請由正常管道進入";
    exit;
}

$name = $_POST["name"];
$sql = "INSERT INTO brand (name) VALUES ('$name')";

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
    $last_id = $conn->insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: addBrand.php");
