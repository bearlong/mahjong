<?php
require_once("../db_connect_mahjong.php");
session_start();

$sqlReturn  = "SELECT * FROM rent_record WHERE 1";
$resultReturn  = $conn->query($sqlReturn);
$rowsReturn = $resultReturn->fetch_all(MYSQLI_ASSOC);
foreach ($rowsReturn  as $return) {
    if ($return["return_date"] !== null) {
        $sqlStatus = "UPDATE rent_record SET status = 0 WHERE id = " . $return["id"];
    } else {
        $now = date('Y-m-d');
        if ($now > $return["due_date"]) {
            $sqlStatus = "UPDATE rent_record SET status = 2 WHERE id = " . $return["id"];
        } else {
            $sqlStatus = "UPDATE rent_record SET status = 1 WHERE id = " . $return["id"];
        }
    }

    if ($conn->query($sqlStatus) === TRUE) {
    } else {
        echo "Error: " . $sqlStatus . "<br>" . $conn->error;
    }
}


$order = "ORDER BY rent_record.order_date DESC";
$filter = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $filter .= "AND (users.username  LIKE '%$search%' OR rent_product.name LIKE '%$search%')";
}
if (isset($_GET["start"]) && isset($_GET["end"])) {
    $dateStart = $_GET["start"];
    $dateEnd = $_GET["end"];
    $dateEnd .= " 23:59:59";
    $filter .= "AND rent_record.order_date BETWEEN '$dateStart' AND '$dateEnd'";
}

if (isset($_GET["status"])) {
    $status = $_GET["status"];
    $filter .= "AND rent_record.status = '$status'";
}

if (isset($_GET["user"])) {
    $user = $_GET["user"];
    $filter .= "AND rent_record.user_id = '$user'";
}

if (isset($_GET["product"])) {
    $product = $_GET["product"];
    $filter .= "AND rent_record.product_id = '$product'";
}

if (isset($_GET["order"])) {
    switch ($_GET["order"]) {
        case 1:
            $order = "ORDER BY rent_record.order_date DESC";
            break;
        case 2:
            $order = "ORDER BY rent_record.order_date ASC";
            break;
        case 3:
            $order = "ORDER BY rent_record.due_date DESC";
            break;
        case 4:
            $order = "ORDER BY rent_record.due_date ASC";
            break;
    };
}



$sql = "SELECT rent_record.*, 
users.username AS user_name, 
rent_product.name AS rent_product_name, 
rent_product.price, 
rent_product.rent_price_category_id, 
rent_price_category.rent_price, 
rent_price_category.rent_day , 
users.id AS user_id,
rent_product.id AS rent_product_id
FROM rent_record JOIN users ON users.id = rent_record.user_id JOIN rent_product ON rent_record.product_id = rent_product.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE 1 $filter $order";
$result = $conn->query($sql);
$resultCount = $result->num_rows;


if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $prepage = 15;
    $firstItem = ($page - 1) * $prepage;
    $pageCount = ceil($resultCount / $prepage);
    $sqlPage = $sql . " LIMIT $firstItem, $prepage";
} else {
    header("location: rent-record-list.php?page=1");
    exit;
}

$resultPage = $conn->query($sqlPage);
$rows = $resultPage->fetch_all(MYSQLI_ASSOC);

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
    <style>
        .order {
            display: none;
        }
    </style>
</head>

<body>
    <?php include("../nav.php"); ?>
    <div class="container main-content px-5">
        <h1 class="text-center fw-semibold ">租借紀錄表</h1>
        <div class="d-flex g-3 justify-content-between py-2">
            <div>
                <?php if (isset($_GET["search"]) || isset($_GET["start"]) || isset($_GET["end"]) || isset($_GET["status"]) || isset($_GET["user"]) || isset($_GET["product"]) || isset($_GET["order"])) : ?>
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

            </div>
        </div>
        <div class="py-2 d-flex justify-content-between">
            <div>

                <div class="row g-3 align-items-center">
                    <!-- <input type="hidden" name="page" value="1"> -->
                    <div class="col-auto">
                        訂單時間
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="start" id="start_date">
                    </div>
                    <div class="col-auto">~</div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="end" id="end_date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                </form>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div>
                    <select class="form-select" aria-label="Default select example" id="status">
                        <option value="" <?php if (!isset($_GET["status"])) echo "selected" ?>>總覽</option>
                        <!-- <option value="divider" disabled class="divider">--- 分隔線 ---</option> -->
                        <option value="0" <?php if (isset($_GET["status"]) && $_GET["status"] == 0) echo "selected" ?>>已結案</option>
                        <option value="1" <?php if (isset($_GET["status"]) && $_GET["status"] == 1) echo "selected" ?>>出借中</option>
                        <option value="2" <?php if (isset($_GET["status"]) && $_GET["status"] == 2) echo "selected" ?>>已逾期</option>
                    </select>
                </div>
                <div class="mx-3">
                    <p class="text-secondary m-0">共 <?= $resultCount ?> 筆訂單</p>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>租借人</th>
                    <th>商品</th>
                    <th>
                        <a href="?page=1&order=2<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] >= 3) echo "d-block" ?>">訂單日期<i class="fa-solid fa-sort ms-2"></i></a>
                        <a href="?page=1&order=2<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 1) echo "d-block" ?>">訂單日期<i class="fa-solid fa-sort-up ms-2"></i></a>
                        <a href="?page=1&order=1<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 2) echo "d-block" ?>">訂單日期<i class="fa-solid fa-sort-down ms-2"></i></a>
                    </th>
                    <th>租借日期</th>
                    <th>
                        <a href="?page=1&order=4<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] <= 2) echo "d-block" ?>">預計歸還日<i class="fa-solid fa-sort ms-2"></i></a>
                        <a href="?page=1&order=4<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 3) echo "d-block" ?>">預計歸還日<i class="fa-solid fa-sort-up ms-2"></i></a>
                        <a href="?page=1&order=3<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 4) echo "d-block" ?>">預計歸還日<i class="fa-solid fa-sort-down ms-2"></i></a>
                    </th>
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
                        <td><a class="text-decoration-none" href="?page=1&user=<?= $rent_order["user_id"] ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>"><?= $rent_order["user_name"] ?></a></td>
                        <td><a class="text-decoration-none" href="?page=1&product=<?= $rent_order["rent_product_id"] ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>"><?= $rent_order["rent_product_name"] ?></a></td>
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
        <div class="btn-toolbar justify-content-center pb-3 " role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group" role="group" aria-label="First group">
                <?php if (isset($_GET["page"])) : ?>
                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                        <a type="button" class="btn btn-outline-primary <?php if ((int)$page === $i) echo "active" ?>" href="?page=<?= $i ?><?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>"><?= $i ?></a>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        const start_date = document.getElementById("start_date");
        const end_date = document.getElementById("end_date");
        const status = document.querySelector("#status");


        start_date.addEventListener("change", function() {
            end_date.min = this.value;
        });
        end_date.addEventListener("change", function() {
            start_date.max = this.value;
        });

        status.addEventListener("change", (e) => {

            if (e.target.value == "") {
                location.href = `rent-record-list.php?page=1`;
            } else {
                location.href = `rent-record-list.php?page=1&status=${e.target.value}<?= isset($_GET["user"]) ? "&user=" . $_GET["user"] : "" ?><?= isset($_GET["product"]) ? "&product=" . $_GET["product"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?><?= isset($_GET["start"]) ? "&start=" . $_GET["start"] : "" ?><?= isset($_GET["end"]) ? "&end=" . $_GET["end"] : "" ?>`;
            }


        });
    </script>
</body>

</html>