<?php
// 連接資料庫
require_once("../db_connect_mahjong.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account = $_POST["account"];
    $password = $_POST["password"];
    $company_name = $_POST["company_name"];
    $company_phone = $_POST["company_phone"];
    // $fax_phone = $_POST["fax_phone"];
    $company_email = $_POST["company_email"];
    $company_address = $_POST["company_address"];
    $responsible_person = $_POST["responsible_person"];
    $tax_ID_number = $_POST["tax_ID_number"];




    $sql = "INSERT INTO owner ( account, password, company_name, company_phone , fax_phone, company_email, company_address, responsible_person, tax_ID_number) VALUES ('$account', '$password', '$company_name', '$company_phone', '$fax_phone', '$company_email', '$company_address', '$responsible_person', '$tax_ID_number' )";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "<script>alert('註冊成功！'); window.location.href='login.php';</script>";
        header("location: login.php");
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
