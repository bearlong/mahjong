<?php
require_once("../db_connect_mahjong.php");
session_start();
if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT rent_product.*, rent_category.name AS category_name, rent_price_category.rent_price, rent_price_category.rent_day, rent_price_category.range  FROM rent_product JOIN rent_category ON rent_product.category_id = rent_category.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE rent_product.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlImages = "SELECT * FROM rent_images WHERE rent_product_id = $id";
$resultImages = $conn->query($sqlImages);
$rowsImages  = $resultImages->fetch_all(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $row["name"] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php") ?>

    <style>
        .img-box {
            width: 100px;
            height: 100px;
            overflow: hidden;
        }

        .small-pic {
            border: 4px solid transparent;

            &:hover {
                border: 4px solid #0D6EFD;
            }
        }

        .pic-active {
            border: 4px solid #0D6EFD;
        }
    </style>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <a href="rent-product-list.php" class="btn btn-primary btn-sm my-2"><i class="fa-solid fa-left-long me-2"></i>租借產品列表</a>
        <div class="row g-5">
            <div class="col-6">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-2">商品名稱</th>
                            <td class="col-10">
                                <h2><?= $row["name"] ?></h2>
                            </td>
                        </tr>
                        <tr>
                            <th>類別</th>
                            <td>
                                <p><?= $row["category_name"] ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>商品敘述</th>
                            <td>
                                <p><?= nl2br($row["content"]) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>庫存</th>
                            <td>
                                <div class="d-flex gap-3">
                                    <p>庫存總數: <?= $row["quantity"] ?></p>
                                    <p>剩餘庫存: <?= $row["quantity_available"] ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>定價/租金</th>
                            <td>
                                <div class="d-flex gap-3">
                                    <p>定價: <?= number_format($row["price"]) ?></p>
                                    <p>租金: <?= number_format($row["rent_price"]) ?>/<?= $row["rent_day"] ?>天</p>
                                    <p class="text-secondary"><?php if ($row["rent_price_category_id"] == 1) {
                                                                    echo "最短租約半年";
                                                                } ?></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex gap-3 py-3">
                        <?php foreach ($rowsImages as $image) : ?>
                            <div class="img-box ratio ratio-1x1 position-relative">
                                <img class="object-fit-cover small-pic" src="../images/rent_product/<?= $row["id"] ?>/<?= $image["url"] ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex flex-column">
                    <div>
                        <img class="img-fluid main-pic" src="../images/rent_product/<?= $row["id"] ?>/<?= $row["img"] ?>" alt="<?= $row["name"] ?>">
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script>
        const mainPic = document.querySelector(".main-pic");
        const smallPics = document.querySelectorAll(".small-pic");

        for (let i = 0; i < smallPics.length; i++) {
            smallPics[i].addEventListener("click", function() {
                for (let j = 0; j < smallPics.length; j++) {
                    smallPics[j].classList.remove("pic-active");
                }
                mainPic.src = this.src;
                this.classList.add("pic-active");
            });
        }
    </script>
    <?php include("../js-mahjong.php") ?>
</body>

</html>