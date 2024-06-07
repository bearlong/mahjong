<?php
require_once("../db_connect_mahjong.php");

if (!isset($_POST["username"])) {
  echo "請循正常管道進入此頁";
  exit;
}


$username = $_POST["username"];
$account = $_POST["account"];
$password = $_POST["password"];
$address = $_POST["address"];
$birth = $_POST["birth"];
$gender = $_POST["gender"];

$email = $_POST["email"];
$phone = $_POST["phone"];

if (empty($phone) || empty($email) || empty($phone)) {
  echo "請填入必要欄位";
  header("location: create-user.php");
  exit;
}

// echo "$name,$email,$phone";


$now = date('Y-m-d H:i:s');


$sql = "INSERT INTO users ( username, account, password, Address, birth, gender, phone, email, created_at)
	VALUES ('$username', '$account', '$password', '$Address', '$birth','$gender', '$phone', '$email','$now')
  ";
// echo $sql;
// exit;


if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "新資料輸入成功, id 為 $last_id";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("location: users.php");
