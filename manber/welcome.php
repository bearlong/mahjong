<?php
session_start();
require_once("../db_connect_mahjong.php");



$account = $_POST["account"];
$password = $_POST["password"];



if (empty($account)) {
  $errorMsg = "請輸入帳號";
  $_SESSION["errorMsg"] = $errorMsg;

  header("location:login.php");
  exit;
}

if (empty($password)) {
  $errorMsg = "請輸入密碼";
  $_SESSION["errorMsg"] = $errorMsg;
  header("location:login.php");
  exit;
}
$sql = "SELECT * FROM users WHERE account = '$account' AND password = '$password'AND valid=1";




$result = $conn->query($sql);
$userCount = $result->num_rows;

if ($userCount == 0) {
  $errorMsg = "帳號或密碼錯誤";
  $_SESSION["errorMsg"] = $errorMsg;

  header("location:login.php");
  exit;
}
header("location:../sidebar-nav.php");


?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>歡迎頁面</title>
</head>

<body>
  <h2>歡迎, <?php echo $account; ?>!</h2>
  <a href="logout.php">登出</a>
</body>

</html>