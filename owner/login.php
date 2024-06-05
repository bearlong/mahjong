<?php
session_start();

require_once("../db_connect_mahjong.php");

if (isset($_SESSION["owner"])) {
    header("Location:dashboard.php");
    exit;
  }


?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入及註冊畫面</title>
    <?php include("../css-mahjong.php") ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 130vh; */
            margin: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .toggle-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .toggle-buttons button {
            flex: 1;
            padding: 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
        }

        .toggle-buttons button:not(:last-child) {
            margin-right: 10px;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        /* .form .inputbox {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        } */

        .form button {
            width: 80%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container m-5">
        <div class="toggle-buttons">
            <button id="loginBtn">登入</button>
            <button id="registerBtn">註冊</button>
        </div>

        <form action="welcome.php" id="loginForm" class="form active" method="post">
            <div class="py-2">
                <input class="form-control" name="username" type="text" placeholder="帳號" required>
            </div>
            <div class="py-2">
                <input class="form-control" name="password" type="password" placeholder="密碼" required>
            </div>
            <div class="d-flex py-2">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked">
                    Remember me
                </label>
                <?php if (isset($_SESSION["errorMsg"])): ?>
                <div><?= $_SESSION["errorMsg"]   ?></div>      
          
            <?php unset($_SESSION["errorMsg"]) ?>
            <?php endif; ?>
            </div>
            <button type="submit">登入</button>
        </form>

        <form id="registerForm" class="form" method="post" action="register.php">
            <div class="py-2">
                <input class="form-control" type="text" name="account" placeholder="請輸入 4~20字元的帳號" required>
            </div>
            <div class="py-2">
                <input class="form-control" type="password" name="password" placeholder="密碼" id="password" required>
            </div>
            <div class="py-2">
                <input class="form-control" type="text" name="company_name" placeholder="公司名稱" required>
            </div>
            <div class="py-2">
                <input class="form-control" type="phone" name="company_phone" placeholder="公司電話" required>

            </div>
            <div class="py-2">
                <input class="form-control" type="phone" name="fax_phone" placeholder="公司傳真" required>

            </div>
            <div class="py-2">
                <input class="form-control" type="email" name="company_email" placeholder="公司E-mail" required>

            </div>
            <div class="py-2">
                <input class="form-control" type="text" name="company_address" placeholder="公司地址" required>
            </div>
            <div class="py-2">
                <input class="form-control" type="text" name="responsible_person" placeholder="負責人" required>
            </div>
            <div class="py-2">
                <input class="form-control" type="text" name="tax_ID_number" placeholder="公司統編" required>
            </div>
            <button type="submit">註冊</button>
        </form>
    </div>

    <script>
        const loginBtn = document.getElementById('loginBtn');
        const registerBtn = document.getElementById('registerBtn');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginBtn.addEventListener('click', () => {
            loginForm.classList.add('active');
            registerForm.classList.remove('active');
        });

        registerBtn.addEventListener('click', () => {
            registerForm.classList.add('active');
            loginForm.classList.remove('active');
        });
    </script>

</body>

</html>