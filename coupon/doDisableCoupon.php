<?php
require_once("../db_connect_mahjong.php");


$couponId = intval($_GET['coupon_id']); // 防止 SQL 注入
$updateSql = "UPDATE coupons SET status = 'inactive' WHERE coupon_id = $couponId";

$response = [];
if ($conn->query($updateSql) === TRUE) {
  $response['operation_result'] = "success";
} else {
  $response['operation_result'] = "error";
  $response['error'] = $conn->error; // 返回錯誤信息
}

echo json_encode($response);
