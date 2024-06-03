<?php
require_once("../db_connect_mahjong.php");



$room_id = 1;
$table_type = $_POST["table_type"];
$price = $_POST["price"];
$name = $_POST["name"];

$now = date('Y-m-d H:i:s');

$status = 0;


$sql = "INSERT INTO marjong_table (table_type, price, create_at,room_id,status,name)
VALUES ('$table_type', '$price','$now','$room_id','$status','$name')";

if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "新資料輸入成功, id 為 $last_id";
  header("location: index.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
