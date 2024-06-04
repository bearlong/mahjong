<?php
require_once("../db_connect_mahjong.php");
if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}



$sql = "SELECT rent_record.*, 
users.username AS user_name, 
rent_product.name AS rent_product_name, 
rent_product.price, 
rent_product.rent_price_category_id, 
rent_price_category.rent_price, 
rent_price_category.rent_day 
FROM rent_record JOIN users ON users.id = rent_record.user_id JOIN rent_product ON rent_record.product_id = rent_product.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE rent_record.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$title = $row["user_name"] . " 訂單內容";

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php"); ?>
</head>

<body>
    <div class="container px-5">
        <h1 class="fw-semibord py-3"><?= $title ?></h1>
        <a href="rent-record-list.php" class="btn btn-primary btn-sm my-2"><i class="fa-solid fa-left-long me-2"></i>租借紀錄列表</a>
        <div class="row justify-content-center">
            <div class="col-8">
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <td><?= $row["id"] ?></td>
                    </tr>
                    <tr>
                        <th>租借人</th>
                        <td><?= $row["user_name"] ?></td>
                    </tr>
                    <tr>
                        <th>產品名稱</th>
                        <td><?= $row["rent_product_name"] ?></td>
                    </tr>
                    <tr>
                        <th>租借日期</th>
                        <td><?= $row["rental_date"] ?></td>
                    </tr>
                    <tr>
                        <th>租借天數</th>
                        <td><?= $row["rent_day"] ?></td>
                    </tr>
                    <tr>
                        <th>預計歸還日</th>
                        <td><?= $row["due_date"] ?></td>
                    </tr>
                    <tr>
                        <th>訂單狀態</th>
                        <td class="<?php
                                    switch ($row["status"]) {
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
                                    ?> fw-semibold"><?php switch ($row["status"]) {
                                                        case 0:
                                                            echo "已結案";
                                                            break;
                                                        case 1:
                                                            echo "出借中";
                                                            break;
                                                        case 2:
                                                            echo "已逾期";
                                                            break;
                                                    } ?></td>
                    </tr>
                    <?php if ((int)$row["status"] === 2) : ?>
                        <tr>
                            <th>罰金試算(當日)</th>
                            <td class="text-danger"><?php
                                                    $now = date('Y-m-d');
                                                    $now = new DateTime($now);
                                                    $due_date = new DateTime($row["due_date"]);
                                                    $interval = $due_date->diff($now);
                                                    $days = $interval->days;
                                                    $fine = $days / $row["rent_day"] * $row["rent_price"];
                                                    if (ceil($fine) <= $row["price"]) {
                                                        $fine = ceil($fine);
                                                        echo  $fine;
                                                    } else {
                                                        $fine = $row["price"];
                                                        echo $fine;
                                                    }
                                                    ?></td>
                        </tr>
                        <tr>
                            <th>歸還日期</th>
                            <td>
                                <form action="doReturn.php" method="post">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <input type="date" name="return-date" class="form-control" id="returnDate">
                                            <input type="hidden" name="fine" id="fine">
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-success">歸還</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <th>歸還日期</th>
                            <td>
                                <?php if ($row["return_date"] !== null) : ?>
                                    <?= $row["return_date"] ?>
                                <?php else : ?>
                                    <form action="doReturn.php" method="post">
                                        <div class="row">
                                            <div class="col-10">
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                <input type="date" name="return-date" class="form-control" id="returnDate">
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-success">歸還</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if ($row["fine"] !== null) : ?>
                            <tr>
                                <th>罰金</th>
                                <td><?= $row["fine"] ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php"); ?>

    <script>
        const returnDate = document.querySelector("#returnDate");
        const fine = document.querySelector("#fine");

        returnDate.addEventListener("change", () => {
            let date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // 月份從0開始，所以需要加1
            const day = String(date.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;

            if (returnDate.value !== formattedDate) {
                const date1 = new Date(returnDate.value);
                const date2 = new Date("<?= $row["due_date"] ?>");
                const differenceInMilliseconds = date1 - date2;
                const millisecondsPerDay = 24 * 60 * 60 * 1000; // 一天的毫秒數
                const differenceInDays = differenceInMilliseconds / millisecondsPerDay;
                console.log(differenceInDays);
                const fineTotal = Math.round(differenceInDays / <?= $row["rent_day"] ?> * <?= $row["rent_price"] ?>);
                if (fineTotal > <?= $row["price"] ?>) {
                    fine.value = <?= $row["price"] ?>;
                } else {
                    fine.value = fineTotal;
                }
            } else {
                fine.value = <?= $fine ?>;
            };

        });
    </script>
</body>

</html>