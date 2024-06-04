<?php
require_once("../db_connect_mahjong.php");


if (!isset($_POST["company_name"])) {
  echo "請循正常管道進入此頁";
  exit;
}

$id = $_POST["id"];

$account = $_POST["account"];
$password = $_POST["password"];
$company_name = $_POST["company_name"];
$company_phone = $_POST["company_phone"];
$responsible_person = $_POST["responsible_person"];
$company_email = $_POST["company_email"];
$company_address = $_POST["company_address"];
$tax_ID_number = $_POST["tax_ID_number"];

$sql = "UPDATE owner SET responsible_person='$responsible_person',  account='$account', password='$password', company_address='$company_address', company_name='$company_name', company_phone='$company_phone', company_email='$company_email' , tax_ID_number='$tax_ID_number' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  echo "更新成功";
} else {
  echo "更新資料錯誤: " . $conn->error;
}

header("location:user.php?id=" . $id);

$conn->close();
