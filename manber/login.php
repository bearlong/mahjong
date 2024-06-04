<?php
session_start();

require_once("../db_connect_mahjong.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            header("Location: index.html"); // 登入成功後重定向到首頁
            exit;
        } else {
            echo "密碼錯誤";
        }
    } else {
        echo "無此使用者";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入及註冊畫面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        .form input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

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
            <input name="username" type="text" placeholder="帳號" required>
            <input name="password" type="password" placeholder="密碼" required>
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
                Remember me
            </label>
            <button type="submit">登入</button>
        </form>

        <form id="registerForm" class="form" method="post" action="register.php">
            <input type="text" name="account" placeholder="請輸入 4~20字元的帳號" required>
            <input type="password" name="password" placeholder="密碼" id="password" required>
            <input type="password" name="password" id="repassword" placeholder="再輸入一次密碼" required>
            <input type="email" name="email" placeholder="電子郵件" required>
            <input type="text" name="username" placeholder="用戶名" required>
            <input type="phone" name="phone" placeholder="電話" required>
            <br>
            <select class="form-select" name="gender" aria-label="Default select example">
                <option selected>性別</option>
                <option value="male">男</option>
                <option value="female">女</option>
            </select>
            <br>
            <select class="form-select" name="city" aria-label="Default select example">
                <option selected>選擇城市</option>
                <option value="taipei">台北</option>
                <option value="Taichung">台中</option>
                <option value="Kaohsiung">高雄</option>
            </select>
            <input type="Address" name="Address" placeholder="完整地址" required>
            <label>
                Enter your birthday:
                <input type="date" name="birth" required pattern="\d{4}-\d{2}-\d{2}" />
                <span class="validity"></span>
            </label>




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