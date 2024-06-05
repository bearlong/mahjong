<?php
require_once("../db_connect_mahjong.php");
session_start();

$title = "產品列表";
$sql = "SELECT product.*, product_category.name AS category_name, brand.name AS brand_name FROM product JOIN product_category ON product_category.id = product.category_id JOIN brand ON brand.id = product.brand_id";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$sqlMaxMin = "SELECT MAX(price) as max_price, MIN(price) as min_price FROM product";
$result = $conn->query($sqlMaxMin);

if ($result->num_rows > 0) {
    // 取出結果
    $rowMaxMin = $result->fetch_assoc();
    $max_price = $rowMaxMin["max_price"];
    $min_price = $rowMaxMin["min_price"];
}
?>


<!doctype html>
<html lang="en">

<head>
    <title><?= $title  ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php") ?>
    <style>
        .img-box {
            width: 120px;
        }

        .object-fit-conver {
            width: 100%;
            height: 100%;
        }

        .content {
            width: 200px;
            /* height: 80px; */
            display: -webkit-box;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
    </style>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="modal fade" id="deleteBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">確認下架</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確定要下架嗎?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="" type="button" class="btn btn-danger" id="confirm">確認</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-content px-5">
        <h1 class="text-center fw-semibold py-3"><?= $title ?></h1>
        <div class="row">
            <div class="col-4">
                <form action="">
                    <div class="range-container">
                        <label for="minRange">min: <span id="minValue"></span></label>
                        <input class="form-range" name="min" type="range" id="minRange" min="<?= $min_price ?>" max="<?= $max_price ?>" value="<?= $min_price ?>">
                        <label for="maxRange">max: <span id="maxValue"></span></label>
                        <input class="form-range" name="max" type="range" id="maxRange" min="<?= $min_price ?>" max="<?= $max_price ?>" value="<?= $max_price ?>">
                        <button type="submit" class="btn btn-primary">送出</button>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>id</th>
                <th>品名</th>
                <th>品牌</th>
                <th>類別</th>
                <th>庫存數量</th>
                <th>價錢</th>
                <th>圖片</th>
                <th>商品敘述</th>
                <th>狀態</th>
                <th>更多</th>
            </tr>
            <?php foreach ($rows as $product) : ?>
                <tr>
                    <td><?= $product["id"] ?></td>
                    <td class="fw-semibold <?php if ($product["off_time"]) echo "text-secondary text-opacity-50" ?>"><?= $product["name"] ?></td>
                    <td><?= $product["brand_name"] ?></td>
                    <td><?= $product["category_name"] ?></td>
                    <td><?= $product["quantity"] ?></td>
                    <td><?= $product["price"] ?></td>
                    <td>
                        <div class="img-box ratio ratio-4x3 position-relative z-0">
                            <img class="object-fit-cover" src="../images/product/<?= $product["img"] ?>" alt="">
                        </div>
                    </td>
                    <td>
                        <div class="content">
                            <?= $product["content"] ?>
                        </div>
                    </td>
                    <td>
                        <?php if ($product["off_time"]) : ?>
                            <span class="text-danger fw-semibold">已下架</span>
                        <?php else : ?>
                            <span class="text-success fw-semibold">上架中</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between align-items-center flex-column gap-2">
                            <a href="product.php?id=<?= $product["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                            <?php if ($product["off_time"]) : ?>
                                <button data-id="<?= $product["id"] ?>" type="button" class="deleteBtn btn btn-secondary" disabled data-bs-toggle="modal" data-bs-target="#deleteBackdrop">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php else : ?>
                                <button data-id="<?= $product["id"] ?>" type="button" class="deleteBtn btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBackdrop">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        const deleteBtn = document.querySelectorAll('.deleteBtn');
        const confirm = document.querySelector('#confirm');

        for (let i = 0; i < deleteBtn.length; i++) {

            deleteBtn[i].addEventListener("click", function() {
                let id = deleteBtn[i].dataset.id;
                console.log(id);
                confirm.href = "./doDeleteProduct.php?id=" + id;
            })
        }

        const minRange = document.getElementById('minRange');
        const maxRange = document.getElementById('maxRange');
        const minValue = document.getElementById('minValue');
        const maxValue = document.getElementById('maxValue');
        minValue.textContent = minRange.value;
        maxValue.textContent = maxRange.value;

        minRange.addEventListener('input', function() {
            minValue.textContent = minRange.value;
        });

        maxRange.addEventListener('input', function() {
            maxValue.textContent = maxRange.value;
        });
    </script>

</body>

</html>