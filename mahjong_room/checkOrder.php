<?php
require_once("../db_connect_mahjong.php");
session_start();

$id = $_GET["id"];
print_r($id);

$sqlTable = "SELECT mahjong_table.*, mahjong_room.open_time, mahjong_room.close_time FROM mahjong_table JOIN mahjong_room ON mahjong_table.room_id = mahjong_room.room_id WHERE id = $id";
$resultTable = $conn->query($sqlTable);
$rowsTable = $resultTable->fetch_assoc();


$sqlOrder = "SELECT mahjong_table.*, history.date, history.start_time, history.end_time FROM mahjong_table JOIN history ON mahjong_table.id = history.table_id";
$resultOrder = $conn->query($sqlOrder);
$rowsOrder = $resultOrder->fetch_all(MYSQLI_ASSOC);
$bookingStatus = [];

$openTime = strtotime($rowsTable['open_time']);
$closeTime = strtotime($rowsTable['close_time']);

$currentTime = $openTime;

while ($currentTime < $closeTime) {
    $startTime = date("H:i:s", $currentTime);
    $endTime = date("H:i:s", strtotime('+1 hour', $currentTime));
    foreach ($rowsOrder as $rowOrder) {
        if ($id == $rowOrder['id'] && $rowOrder['start_time'] == $startTime) {
            $bookingStatus[$startTime] = '已預定';
        } else {
            $bookingStatus[$startTime] = '空閒';
        }
    }

    $currentTime = strtotime('+1 hour', $currentTime);
}
$currentTime = $openTime;
print_r($bookingStatus);
