<?php
require_once("../db_connect_mahjong.php");

session_start();
if (!isset($_POST["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_POST["id"];
$return_date = $_POST["return-date"];
$fine = 0;

if (isset($_POST["fine"])) {
    $fine = $_POST["fine"];
}

$sql = "UPDATE rent_record SET return_date = '$return_date', fine = '$fine', status = '0' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("location: rent-record.php?id=$id");
} else {
    echo "Error: " . $sqlEdit . "<br>" . $conn->error;
}
