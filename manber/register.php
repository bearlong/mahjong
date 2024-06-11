<?php
// 連接資料庫
require_once("../db_connect_mahjong.php");
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION["register"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordCheck = $_POST["passwordCheck"];
        $account = $_POST["account"];

        if (empty($username)) {
            $errorMsg = "請輸入用戶名";
            $_SESSION["errorMsg"] = $errorMsg;
            header("location:login.php");
            exit;
        };

        if (empty($account) || strlen($account) > 20 ||  strlen($account) < 4) {
            $errorMsg = "請輸入4~20字元的帳號";
            $_SESSION["errorMsg"] = $errorMsg;
            header("location:login.php");
            exit;
        };

        $sql = "SELECT * FROM users where account = '$account'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $errorMsg = "此帳號已註冊過";
            $_SESSION["errorMsg"] = $errorMsg;
            header("location:login.php");
            exit;
        }


        if (empty($password)) {
            $errorMsg = "請輸入密碼";
            $_SESSION["errorMsg"] = $errorMsg;
            header("location:login.php");
            exit;
        };

        if ($password !== $passwordCheck) {
            $errorMsg = "密碼與確認密碼不一致";
            $_SESSION["errorMsg"] = $errorMsg;
            header("location:login.php");
            exit;
        };

        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $_SESSION["register"]["username"] = $username;
        $_SESSION["register"]["account"] = $account;
        $_SESSION["register"]["password"] = $password;
        header("location:login.php");
        exit;
    }

    $username = $_SESSION["register"]["username"];
    $account = $_SESSION["register"]["account"];
    $password = $_SESSION["register"]["password"];
    $email = $_POST["email"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $birth = $_POST["birth"];
    $gender = $_POST["gender"];

    if (empty($email)) {
        $errorMsg = "請輸入email";
        $_SESSION["errorMsg"] = $errorMsg;
        header("location:login.php");
        exit;
    };

    $sql = "SELECT * FROM users where email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $errorMsg = "此email已註冊過";
        $_SESSION["errorMsg"] = $errorMsg;
        header("location:login.php");
        exit;
    }

    if (empty($phone)) {
        $errorMsg = "請輸入電話";
        $_SESSION["errorMsg"] = $errorMsg;
        header("location:login.php");
        exit;
    };

    if (empty($address)) {
        $errorMsg = "請輸入地址";
        $_SESSION["errorMsg"] = $errorMsg;
        header("location:login.php");
        exit;
    };

    if (empty($birth)) {
        $errorMsg = "請輸入生日";
        $_SESSION["errorMsg"] = $errorMsg;
        header("location:login.php");
        exit;
    };


    $sql = "INSERT INTO users (username, email, password, account, city, gender, address, phone, birth) VALUES ('$username', '$email', '$password', '$account', '$city', '$gender', '$address', '$phone', '$birth')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        unset($_SESSION["register"]);
        $_SESSION["register_success"] = TRUE;
        header("location: login.php");
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
