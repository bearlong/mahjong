<?php
session_start();

require_once("../db_connect_mahjong.php");

if (isset($_SESSION["users"])) {
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
            height: 100vh;
            margin: 0;
            background-image: url("../images/good.jpg");
            background-size: cover;
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
            margin-bottom: 20px;
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

        /* .form input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        } */

        .form button {
            width: 100%;
            padding: 10px;
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

    <div class="container">
        <div class="toggle-buttons">
            <button id="loginBtn">登入</button>
            <button id="registerBtn">註冊</button>
        </div>

        <form action="welcome.php" id="loginForm" class="form active" method="post">
            <div class="pb-2">
                <input class="form-control" name="account" type="text" placeholder="帳號" required>
            </div>
            <div class="pb-2">

                <input class="form-control" name="password" type="password" placeholder="密碼" required>
            </div>
            <div class="pb-2">

                <label class="form-check-label" for="flexCheckChecked">
                    Remember me
                </label>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            </div>

            <?php if (isset($_SESSION["errorMsg"])) : ?>
                <div class="text-danger py-2"><?= $_SESSION["errorMsg"]   ?></div>

                <?php unset($_SESSION["errorMsg"]) ?>
            <?php endif; ?>
            <button type="submit">登入</button>
        </form>

        <form id="registerForm" class="form" method="post" action="register.php">
            <div class="pb-2">
                <input class="form-control" type="text" name="account" placeholder="請輸入 4~20字元的帳號" required>
            </div>
            <div class="pb-2">
                <input class="form-control" type="password" name="password" placeholder="密碼" id="password" required>
            </div>
            <div class="pb-2">
                <input class="form-control" type="password" name="password" id="repassword" placeholder="再輸入一次密碼" required>
            </div>
            <div class="pb-2">
                <input class="form-control" type="email" name="email" placeholder="電子郵件" required>
            </div>
            <div class="pb-2">
                <input class="form-control" type="text" name="username" placeholder="用戶名" required>
            </div>
            <div class="pb-2">
                <input class="form-control" type="phone" name="phone" placeholder="電話" required>
            </div>
            <div class="pb-2">
                <select class="form-select" name="gender" aria-label="Default select example">
                    <option selected>性別</option>
                    <option value="male">男</option>
                    <option value="female">女</option>
                </select>
            </div>
            <div class="pb-2">
                <select class="form-select" name="city" aria-label="Default select example">
                    <option selected>選擇城市</option>
                    <option value="taipei">台北</option>
                    <option value="Taichung">台中</option>
                    <option value="Kaohsiung">高雄</option>
                </select>
            </div>

            <input class="form-control" type="Address" name="Address" placeholder="完整地址" required>
            <div class="pb-2">

                <label>
                    Enter your birthday: </label>
                <input class="form-control" type="date" name="birth" required pattern="\d{4}-\d{2}-\d{2}" />
                <span class="validity"></span>

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