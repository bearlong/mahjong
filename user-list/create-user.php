<?php
session_start();
?>

<!doctype html>
<html lang="zh-Hant">

<head>
  <title>建立使用者</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("../css-mahjong.php") ?>
  <style>
    .form-container {
      background-color: #fff;
      width: 800px;
      margin: auto;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
    }

    .form-container h1 {
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-container label {
      display: block;
      margin-bottom: 5px;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"],
    .form-container input[type="tel"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #d3d3d3;
      /* 灰色背景 */
    }

    .form-container .radio-group {
      margin-bottom: 10px;
    }

    .form-container .radio-group input {
      margin-right: 10px;
    }

    .form-container .terms {
      font-size: 12px;
      color: #555;
      margin-bottom: 20px;
    }

    .form-container .terms a {
      color: #000;
      text-decoration: underline;
    }

    .form-container button {
      width: 100%;
      padding: 10px;
      background-color: #7b68ee;
      /* 紫色 */
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }

    .form-container button:hover {
      background-color: #6a5acd;
    }

    .form-container .signin {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }

    .form-container .signin a {
      color: #000;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content px-5">
    <div class="form-container">
      <div class="py-2">
        <a class="btn btn-primary" href="users.php?page=1&order=1"><i class="fa-solid fa-arrow-left"></i> 回使用者列表
        </a>
      </div>
      <h1>建立使用者</h1>
      <form action="doCreateUser.php" method="post">
        <div class="mb-2">
          <label for="username" class="form-label">*姓名</label>
          <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-2">
          <label for="account" class="form-label">*帳號</label>
          <input type="text" class="form-control" id="account" name="account">
        </div>
        <div class="mb-2">
          <label for="password" class="form-label">*密碼</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-2">
          <label for="address" class="form-label">*地址</label>
          <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="mb-2">
          <label for="birth" class="form-label">*生日</label>
          <input type="text" class="form-control" id="birth" name="birth">
        </div>
        <div class="mb-2">
          <label for="gender" class="form-label">*性別</label>
          <input type="text" class="form-control" id="gender" name="gender">
        </div>
        <div class="mb-2">
          <label for="email" class="form-label">*email</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-2">
          <label for="phone" class="form-label">*電話</label>
          <input type="tel" class="form-control" id="phone" name="phone">
        </div>

        <button class="btn btn-primary" type="submit">送出</button>
      </form>
    </div>
  </div>
  <?php include("../js-mahjong.php") ?>
</body>

</html>