<?php
require_once("../db_connect_mahjong.php");
$historyAddUser = [];

for ($i = 1; $i <= 12; $i++) {
    $year = 2024;
    $month = $i;
    $start_date = "$year-$month-01";
    $end_date = date("Y-m-t", strtotime($start_date)); // 獲取該月份的最後一天
    $sqlAddUser = "SELECT * FROM users WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
    $resultAddUser = $conn->query($sqlAddUser);
    $AddUser_count = $resultAddUser->num_rows;
    array_push($historyAddUser, $AddUser_count);
}

$sqlGenderyCount = "SELECT  gender,  COUNT(id) AS count FROM users  GROUP BY gender";
$resultGenderyCount = $conn->query($sqlGenderyCount);
$genderCount = [];
if ($resultGenderyCount->num_rows > 0) {
    while ($row = $resultGenderyCount->fetch_assoc()) {
        $genderCount[] = $row;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .line {
            max-width: 960px;
        }
    </style>
    <?php include("../css-mahjong.php"); ?>
</head>

<body>
    <div class="line px-3 pb-3">
        <h1>每月新增用戶</h1>
        <canvas id="myChart2"></canvas>
        <!-- Canvas元素用於繪製走勢圖 -->
    </div>
    <hr>
    <div class="line px-3 pb-3">
        <h1>性別比例</h1>
        <canvas id="myChart4"></canvas>
        <!-- Canvas元素用於繪製走勢圖 -->
    </div>

    <script>
        let data2 = {
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
                label: "新增用戶",
                backgroundColor: "#f00",
                borderColor: "#f00",
                data: [], // 這裡是你的數據
            }, ],
        };
        let database2 = data2["datasets"][0]["data"];
        <?php foreach ($historyAddUser as $user) : ?>
            database2.push(<?= $user ?>);
        <?php endforeach; ?>
        console.log(database2);
        // 配置
        let config2 = {
            type: "line",
            data: data2,
            options: {},
        };

        // 繪製走勢圖
        var myChart2 = new Chart(document.getElementById("myChart2"), config2);

        const myChart4 = document.getElementById('myChart4');

        let data4 = {
            labels: [],
            datasets: [{
                label: '男女比例',
                data: [],
                borderWidth: 1
            }]
        };

        let config4 = {
            type: "bar",
            data: data4,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        let database4 = data4["datasets"][0]["data"];
        <?php foreach ($genderCount as $gender) : ?>
            database4.push(<?= $gender["count"] ?>);
            data4["labels"].push("<?= $gender["gender"] ?>");
        <?php endforeach; ?>
        console.log(database4);
        new Chart(myChart4, config4);
    </script>
    <?php include("../js-mahjong.php") ?>
</body>

</html>