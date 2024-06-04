<?php
require_once("../db_connect_mahjong.php");


if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$username = $_POST["username"];
$email = $_POST["email"];
$name = $_POST["name"];
$email = $_POST["email"];


if (empty($name) || empty($email) || empty($phone)) {
    echo "請填入必要欄位";
    exit;
}

// echo "$name, $email, $phone";

$now = date('Y-m-d H:i:s');

$sql = "INSERT INTO owner (name, phone, email, created_at)
VALUES ('$name', '$phone', '$email', '$now')";
// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: create-user.php");
