<?php
require_once("../db_connect_mahjong.php");
$historyRecord = [];
$historyCategory = [];


for ($i = 1; $i <= 12; $i++) {
  $year = 2024;
  $month = $i;
  $start_date = "$year-$month-01";
  $end_date = date("Y-m-t", strtotime($start_date)); // 獲取該月份的最後一天


  // 查詢特定月份的訂單狀況
  $sqlRent = "SELECT * FROM rent_record WHERE DATE(order_date) BETWEEN '$start_date' AND '$end_date'";
  $resultRent = $conn->query($sqlRent);
  $order_count = $resultRent->num_rows;
  array_push($historyRecord, $order_count);
}



$sqlCategoryCount = "SELECT rent_product.category_id, category.name AS category_name, COUNT(rent_record.id) AS count FROM rent_record JOIN rent_product ON rent_record.product_id = rent_product.id JOIN category ON rent_product.category_id = category.id GROUP BY rent_product.category_id, category.name";

$resultCategoryCount = $conn->query($sqlCategoryCount);

$categoriesCount = [];
if ($resultCategoryCount->num_rows > 0) {
  while ($row = $resultCategoryCount->fetch_assoc()) {
    $categoriesCount[] = $row;
  }
}

// 現在 $categoriesCount 包含每個類別的 id, 名稱和計數

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>走勢圖</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- 引入Chart.js庫 -->
  <style>
    .line {
      max-width: 960px;
    }
  </style>
</head>

<body>
  <div class="line px-3 pb-3">
    <h1>每月租借訂單</h1>
    <canvas id="myChart"></canvas>
    <!-- Canvas元素用於繪製走勢圖 -->
  </div>
  <hr>
  <div class="line px-3 pb-3">
    <h1>租借類別統計</h1>
    <canvas id="myChart3"></canvas>
    <!-- Canvas元素用於繪製走勢圖 -->
  </div>

  <script>
    // 數據
    let data = {
      labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      datasets: [{
        label: "歷史租借訂單",
        backgroundColor: "#f00",
        borderColor: "#f00",
        data: [], // 這裡是你的數據
      }, ],
    };
    let database = data["datasets"][0]["data"];
    <?php foreach ($historyRecord as $record) : ?>
      database.push(<?= $record ?>);
    <?php endforeach; ?>

    // 配置
    let config = {
      type: "line",
      data: data,
      options: {},
    };

    // 繪製走勢圖
    var myChart = new Chart(document.getElementById("myChart"), config);



    const myChart3 = document.getElementById('myChart3');

    let data3 = {
      labels: [],
      datasets: [{
        label: '租借類別',
        data: [],
        borderWidth: 1
      }]
    };

    let config3 = {
      type: "bar",
      data: data3,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };
    let database3 = data3["datasets"][0]["data"];
    <?php foreach ($categoriesCount as $category) : ?>
      database3.push(<?= $category["count"] ?>);
      data3["labels"].push("<?= $category["category_name"] ?>");
    <?php endforeach; ?>
    console.log(database3);
    new Chart(myChart3, config3);
  </script>
  <!-- <script src="script.js"></script> 引入JavaScript文件 -->
</body>

</html>