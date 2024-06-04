<?php
// 連接資料庫
require_once("../db_connect_mahjong.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $account = $_POST["account"];
    $city = $_POST["city"];
    $Address = $_POST["Address"];
    $phone = $_POST["phone"];
    $birth = $_POST["birth"];
    $gender = $_POST["gender"];

    $sql = "INSERT INTO users (username, email, password, account, city, gender, address, phone, birth) VALUES ('$username', '$email', '$password', '$account', '$city', '$gender', '$Address', '$phone', '$birth')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "<script>alert('註冊成功！'); window.location.href='login.php';</script>";
        header("location: login.php");
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
