<?php
require_once("../db_connect_mahjong.php");
session_start();

$sql1 = "SELECT * FROM mahjong_room WHERE room_id = 2 ";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
  // output data of each row
  while ($row1 = $result1->fetch_assoc()) {
    echo "商家:" . $row1["name"] . "<br>";
    echo "電話:" . $row1["tele"] . "<br>";
    echo "地址:" . $row1["address"] . "<br><br>";
  }
} else {
  echo "0 results found in mahjong_room";
}

// 查詢第二個資料表
$sql2 = "SELECT * FROM marjong_table WHERE room_id = 2";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
  // echo "<h2>Another Table Details</h2>";
  // 輸出第二個資料表的每一行資料
  while ($row2 = $result2->fetch_assoc()) {
    echo "name: " . $row2["name"] . "<br>";
    echo "price: " . $row2["price"] . "<br>";
    echo "table_type: " . $row2["table_type"] . "<br>";
    echo "狀態: " . ($row2["status"] == 0 ? "空閒中" : "不可用") . "<br><br>";
  }
} else {
  echo "No results found in another_table";
}
$conn->close();
