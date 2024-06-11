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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // 獲取表單提交的電子郵件和密碼
  $account = $_POST["account"];
  $password = $_POST["password"];

  // 查詢資料庫中的用戶
  $sql = "SELECT id, username, account, email, password FROM users WHERE account = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $account);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    // 獲取用戶數據
    $row = $result->fetch_assoc();
    $hashedPassword = $row["password"];
    $id = $row["id"];
    $username = $row["username"];
    $email = $row["email"];

    $_SESSION["user"]["id"] = $id;
    $_SESSION["user"]["username"] = $username;
    $_SESSION["user"]["email"] = $email;
    $_SESSION["user"]["account"] = $account;



    // 驗證密碼
    if (password_verify($password, $hashedPassword)) {
      // 密碼匹配，設置會話變量標記用戶為已登入
      echo "登入成功";
      // 重定向到其他頁面
      if ($row["account"] == "admin") {
        header("Location: ../sidebar-nav.php");
        exit();
      } else {
        header("Location: ../homepage.php");
        exit();
      }
    } else {
      // 密碼不匹配
      $errorMsg = "密碼錯誤";
      $_SESSION["errorMsg"] = $errorMsg;
      header("location:login.php");
      exit;
    }
  } else {
    // 用戶不存在
    $errorMsg = "用戶不存在";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location:login.php");
    exit;
  }

  // 關閉語句和連接
  $stmt->close();
  $conn->close();
}

// if (password_verify($password, $hashedPassword)) {
//   header("location:sidebar-nav.php");
//   exit;
// } else {
//   $errorMsg = "帳號或密碼錯誤";
//   $_SESSION["errorMsg"] = $errorMsg;
//   header("location:login.php");
//   exit;
// }
