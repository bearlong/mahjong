<?php
require_once("../db_connect_mahjong.php");
session_start();
if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT product.*, product_category.name AS category_name, brand.name AS brand_name FROM product JOIN product_category ON product_category.id = product.category_id JOIN brand ON brand.id = product.brand_id WHERE product.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$title = $row['name'];

$sqlImages = "SELECT * FROM product_images WHERE product_id = $id";
$resultImages = $conn->query($sqlImages);
$rowsImages  = $resultImages->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
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
    </style>

</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <div class="d-flex align-items-start py-2 flex-column">
            <a href="product-list.php" class="btn btn-primary btn-sm mb-2"><i class="fa-solid fa-left-long me-2"></i>商品明細</a>
            <h2 class="pt-3"><?= $row["name"] ?></h2>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="row py-2">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-2">品牌</th>
                            <td class="col-8"><?= $row["brand_name"] ?></td>
                        </tr>
                        <tr>
                            <th>類別</th>
                            <td><?= $row["category_name"] ?></td>
                        </tr>
                        <tr>
                            <th>商品敘述</th>
                            <td><?= nl2br($row["content"]) ?></td>
                        </tr>
                        <tr>
                            <th>庫存數量</th>
                            <td><?= $row["quantity"] ?></td>
                        </tr>
                        <tr>
                            <th>價錢</th>
                            <td><?= $row["price"] ?></td>
                        </tr>
                        <tr>
                            <th>上架日期</th>
                            <td><?= $row["on_time"] ?></td>
                        </tr>
                        <?php if ($row["off_time"]) : ?>
                            <tr>
                                <th>下架日期</th>
                                <td><?= $row["off_time"] ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <div class="d-flex justify-content-start">
                        <a href="editProduct.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                </div>
                <div class="d-flex gap-3 py-3">
                    <?php foreach ($rowsImages as $image) : ?>
                        <div class="img-box ratio ratio-1x1 position-relative">
                            <img class="object-fit-cover small-pic" src="../images/product/<?= $image["img"] ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-4">
                <img class="img-fluid main-pic" src="../images/product/<?= $row["img"] ?>" alt="">
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
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
</body>

</html>