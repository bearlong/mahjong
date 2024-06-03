<?php
require_once("../db_connect_mahjong.php");

if (!isset($_GET["coupon_id"])) {
  echo "請循正常管道進入此頁";
  exit;
}

$coupon_id = $_GET["coupon_id"];

$sql = "UPDATE coupons SET status='inactive' WHERE coupon_id = $coupon_id";

if ($conn->query($sql) === TRUE) {
  echo "刪除成功";
} else {
  echo "刪除失敗: " . $conn->error;
}

header("Location:coupon-list.php?page=1&order=1");
$conn->close();
