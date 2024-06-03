<?php
require_once("../db_connect_mahjong.php");
session_start();

$order = "ORDER BY rent_record.order_date DESC";
$filter = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $filter .= "AND (users.name LIKE '%$search%' OR rent_product.name LIKE '%$search%')";
}

$sql = "SELECT rent_record.*, 
users.name AS user_name, 
rent_product.name AS rent_product_name, 
rent_product.price, 
rent_product.rent_price_category_id, 
rent_price_category.rent_price, 
rent_price_category.rent_day 
FROM rent_record JOIN users ON users.id = rent_record.user_id JOIN rent_product ON rent_record.product_id = rent_product.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE 1 $filter $order";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>租借紀錄表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php"); ?>
    <div class="container main-content px-5">
        <h1 class="py-2">租借紀錄表</h1>
        <div class="d-flex g-3 justify-content-between py-3">
            <div>
                <?php if (isset($_GET["search"]) || isset($_GET["category"]) || isset($_GET["order"])) : ?>
                    <a href="rent-record-list.php" class="btn btn-primary btn-sm my-2"><i class="fa-solid fa-left-long me-2"></i>租借紀錄列表</a>
                <?php endif; ?>
            </div>
            <div class="d-flex">
                <form action="">
                    <div class="input-group position-relative z-0">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon1"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input type="hidden" name="page" value="1">
                        <input type="text" class="form-control" placeholder="search..." aria-label="Example text with button addon" aria-describedby="button-addon1" name="search">
                    </div>
                </form>
            </div>
        </div>
        <div class="py-2">
            <form action="">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        訂單時間
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="start">
                    </div>
                    <div class="col-auto">~</div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="end">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>租借人</th>
                    <th>商品</th>
                    <th>訂單日期</th>
                    <th>租借日期</th>
                    <th>預計歸還日</th>
                    <th>實際歸還日</th>
                    <th>狀態</th>
                    <th>租金</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <?php foreach ($rows as $rent_order) : ?>
                <tbody>
                    <tr>
                        <td><?= $rent_order["id"] ?></td>
                        <td><?= $rent_order["user_name"] ?></td>
                        <td><?= $rent_order["rent_product_name"] ?></td>
                        <td><?= $rent_order["order_date"] ?></td>
                        <td><?= $rent_order["rental_date"] ?></td>
                        <td><?= $rent_order["due_date"] ?></td>
                        <td><?= $rent_order["return_date"] ?></td>
                        <td class="fw-semibold <?php
                                                switch ($rent_order["status"]) {
                                                    case 0:
                                                        echo "text-secondary";
                                                        break;
                                                    case 1:
                                                        echo "text-success";
                                                        break;
                                                    case 2:
                                                        echo "text-danger";
                                                        break;
                                                }
                                                ?>"><?php
                                                    switch ($rent_order["status"]) {
                                                        case 0:
                                                            echo "已結案";
                                                            break;
                                                        case 1:
                                                            echo "出借中";
                                                            break;
                                                        case 2:
                                                            echo "已逾期";
                                                            break;
                                                    }
                                                    ?></td>
                        <td><?php
                            $rental_date = new DateTime($rent_order['rental_date']);
                            $due_date = new DateTime($rent_order['due_date']);
                            $interval = $rental_date->diff($due_date);
                            $days = $interval->days;
                            $rent_price = $days / $rent_order["rent_day"] * $rent_order["rent_price"];
                            echo number_format($rent_price);
                            ?></td>
                        <td>
                            <a href=" rent-record.php?id=<?= $rent_order["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        document.getElementById("start_date").addEventListener("change", function() {
            document.getElementById("end_date").min = this.value;
        });
        document.getElementById("end_date").addEventListener("change", function() {
            document.getElementById("start_date").max = this.value;
        });
    </script>
</body>

</html>