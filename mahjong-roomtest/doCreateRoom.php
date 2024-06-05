<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}
// $id=$_POST["id"];
$id=1;
$name=$_POST["name"];
$tele=$_POST["tele"];
$address=$_POST["address"];
$tax_number=$_POST["tax_number"];


if(empty($name) || empty($tele) || empty($tax_number)|| empty($address)){
    echo "請填入必要欄位";
    exit;
}

$open_time=$_POST["open_time"];
$close_time=$_POST["close_time"];

// echo "$name, $email, $phone";

$now=date('Y-m-d H:i:s');



$sql="INSERT INTO mahjong_room (id,name, tele,address ,tax_number , create_at,open_time,close_time)
VALUES ('','$name', '$tele', '$address','$tax_number', '$now','$open_time','$close_time')";
// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
    header("location: ./dashbord/index.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
