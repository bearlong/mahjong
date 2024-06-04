<?php

if (!isset($_POST["account"])) {
  echo "請循正常管道進入此頁";
  exit;
}


$account = $_POST["account"];
$password = $_POST["password"];
$company_name = $_POST["company_name"];
$company_phone = $_POST["company_phone"];
$company_email = $_POST["company_email"];
$company_address = $_POST["company_address"];
$responsible_person = $_POST["responsible_person"];
$tax_ID_number = $_POST["tax_ID_number"];

if (empty($company_phone) || empty($company_email) || empty($company_address)) {
  echo "請填入必要欄位";
  exit;
}

// echo "$name,$email,$phone";
require_once("../db_connect_mahjong.php");


$now = date('Y-m-d H:i:s');


$sql = "INSERT INTO owner ( account, password, company_name, company_phone,  company_email, company_address, responsible_person, tax_ID_number ) VALUES ('$account', '$password', '$company_name', '$company_phone', '$company_email', '$company_address', '$responsible_person', '$tax_ID_number' )";
// echo $sql;
// exit;


if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "新資料輸入成功, id 為 $last_id";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("location: users.php");
