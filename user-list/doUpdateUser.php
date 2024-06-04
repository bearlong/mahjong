<?php
require_once("../db_connect_mahjong.php");


if (!isset($_POST["username"])) {
  echo "請循正常管道進入此頁";
  exit;
}

$id = $_POST["id"];
$username = $_POST["username"];
$Address = $_POST["Address"];
$birth = $_POST["birth"];
$email = $_POST["email"];
$phone = $_POST["phone"];


$sql = "UPDATE users SET username='$username', Address='$Address', birth='$birth', email='$email' , phone='$phone' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  echo "更新成功";
} else {
  echo "更新資料錯誤: " . $conn->error;
}

header("location:user.php?id=" . $id);

$conn->close();
