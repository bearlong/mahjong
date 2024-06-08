<?php
require_once("../db_connect_mahjong.php");
session_start();
unset($_SESSION["errorMsg"]);

$condition = "";

if (isset($_GET["min"]) && isset($_GET["max"])) {
    $min = $_GET["min"];
    $max = $_GET["max"];
    $condition .= " AND product.price >= $min AND product.price <= $max";
}

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $condition .= " AND (product.name LIKE '%$search%' OR product.content LIKE '%$search%' OR brand.name LIKE '%$search%' OR product_category.name LIKE '%$search%')";
}

if (isset($_GET["brand"])) {
    $brand = $_GET["brand"];
    $condition .= " AND product.brand_id = $brand";
}

if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $condition .= " AND product.category_id = $category";
}

if (isset($_GET["status"])) {
    $status = $_GET["status"];
    if ($status == 1) {
        $condition .= " AND product.off_time IS NULL";
    } else {
        $condition .= " AND product.off_time IS NOT NULL";
    }
}

if (isset($_GET["order"])) {
    $order = $_GET["order"];
    switch ($order) {
        case 1:
            $condition .= " ORDER BY product.id ASC";
            break;
        case 2:
            $condition .= " ORDER BY product.id DESC";
            break;
        case 3:
            $condition .= " ORDER BY product.quantity ASC";
            break;
        case 4:
            $condition .= " ORDER BY product.quantity DESC";
            break;
        case 5:
            $condition .= " ORDER BY product.price ASC";
            break;
        case 6:
            $condition .= " ORDER BY product.price DESC";
            break;
    }
}


$sqlBrand = "SELECT * FROM brand WHERE valid = 1";
$resultBrand = $conn->query($sqlBrand);
$rowsBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);

$sqlCategory = "SELECT * FROM product_category WHERE valid = 1";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

$title = "產品列表";
$sql = "SELECT product.*, product_category.name AS category_name, brand.name AS brand_name FROM product JOIN product_category ON product_category.id = product.category_id AND product_category.valid = 1 JOIN brand ON brand.id = product.brand_id AND brand.valid = 1 WHERE 1$condition";

$sqlPage = $sql;
$result = $conn->query($sql);
$resultCount = $result->num_rows;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $prepage = 15;
    $firstItem = ($page - 1) * $prepage;
    $pageCount = ceil($resultCount / $prepage);
    $sqlPage .= " LIMIT $firstItem, $prepage";
} else {
    header("location: product-list.php?page=1");
    exit;
}

$resultPage = $conn->query($sqlPage);
// $resultCount = $result->num_rows;
$rows = $resultPage->fetch_all(MYSQLI_ASSOC);

$sqlMaxMin = "SELECT MAX(price) as max_price, MIN(price) as min_price FROM product";
$resultMaxMin = $conn->query($sqlMaxMin);

if ($resultMaxMin->num_rows > 0) {
    // 取出結果
    $rowMaxMin = $resultMaxMin->fetch_assoc();
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
            width: 180px;
            /* height: 80px; */
            display: -webkit-box;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .range-container {
            width: 200px;
        }

        .order {
            display: none;
        }

        .sell-out {
            width: 100%;
            height: 100%;
            background: rgba(50, 50, 50, 0.8);
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
    <div class="modal fade" id="addBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">新增確認選項</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="addProduct.php" type="button" class="btn btn-primary me-2">新增商品</a>
                    <a href="addBrand.php" type="button" class="btn btn-primary me-2">品牌管理</a>
                    <a href="addCategory.php" type="button" class="btn btn-primary me-2">類別管理</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-content px-3">
        <h1 class="text-center fw-semibold py-3"><?= $title ?></h1>
        <div class="py-2 justify-content-between d-flex align-items-center">
            <div>
                <?php if (isset($_GET["search"]) || isset($_GET["category"]) || isset($_GET["min"]) || isset($_GET["max"]) || isset($_GET["brand"])) : ?>
                    <a href="product-list.php?page=1" class="btn btn-primary my-2"><i class="fa-solid fa-left-long me-2"></i>回列表</a>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#addBackdrop" class="btn btn-primary ms-3"><i class="fa-solid fa-square-plus me-2"></i>新增</button>
            </div>
        </div>

        <form class="row justify-content-between py-3" action="">
            <input type="hidden" name="page" value="1">
            <div class="col-8">
                <div class="d-flex gap-3 align-items-center">
                    <div class="range-container d-flex flex-column">
                        <label for="minRange">價格 min: <span id="minValue"></span></label>
                        <input class="form-range" name="min" type="range" id="minRange" min="<?= $min_price ?>" max="<?= $max_price ?>" value="<?= $min_price ?>">
                    </div>
                    <div class="range-container d-flex flex-column">
                        <label for="maxRange">價格 max: <span id="maxValue"></span></label>
                        <input class="form-range" name="max" type="range" id="maxRange" min="<?= $min_price ?>" max="<?= $max_price ?>" value="<?= $max_price ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i></button>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group d-flex align-items-center position-relative z-0">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon1"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" class="form-control" placeholder="search..." aria-label="Example text with button addon" aria-describedby="button-addon1" name="search">
                </div>
            </div>
        </form>

        <div class="row pb-2 justify-content-between">
            <div class="col-6">
                <div class="d-flex">
                    <div class="d-flex gap-3">
                        <select class="form-select" aria-label="Default select example" id="brand">
                            <option value="0" <?php if (!isset($_GET["brand"])) echo "selected" ?>>總覽</option>
                            <!-- <option value="divider" disabled class="divider">--- 分隔線 ---</option> -->
                            <?php foreach ($rowsBrand as $brand) : ?>
                                <option value="<?= $brand["id"] ?>" <?php if (isset($_GET["brand"]) && $_GET["brand"] === $brand["id"]) {
                                                                        echo "selected";
                                                                    } ?>><?= $brand["name"] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select class="form-select" aria-label="Default select example" id="category">
                            <option value="0" <?php if (!isset($_GET["category"])) echo "selected" ?>>總覽</option>
                            <!-- <option value="divider" disabled class="divider">--- 分隔線 ---</option> -->
                            <?php foreach ($rowsCategory as $category) : ?>
                                <option value="<?= $category["id"] ?>" <?php if (isset($_GET["category"]) && $_GET["category"] === $category["id"]) {
                                                                            echo "selected";
                                                                        } ?>><?= $category["name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <p class="text-secondary m-0">共 <?= $resultCount ?> 件商品</p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link <?php if (!isset($_GET["status"])) echo "active" ?>" aria-current="page" href="?page=1<?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">總覽</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if (isset($_GET["status"]) && $_GET["status"] == 1) echo "active" ?>" href="?page=1&status=1<?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">上架中</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if (isset($_GET["status"]) && $_GET["status"] == 0) echo "active" ?>" href="?page=1&status=0<?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">已下架</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>
                    <a href="?page=1&order=2<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] >= 3) echo "d-block" ?>">id<i class="fa-solid fa-sort ms-2"></i></a>
                    <a href="?page=1&order=2<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 1) echo "d-block" ?>">id<i class="fa-solid fa-sort-up ms-2"></i></a>
                    <a href="?page=1&order=1<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 2) echo "d-block" ?>">id<i class="fa-solid fa-sort-down ms-2"></i></a>
                </th>
                <th>品名</th>
                <th>品牌</th>
                <th>類別</th>
                <th>
                    <a href="?page=1&order=4<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] < 3 || (int)$_GET["order"] > 4) echo "d-block" ?>">庫存數量<i class="fa-solid fa-sort ms-2"></i></a>
                    <a href="?page=1&order=4<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 3) echo "d-block" ?>">庫存數量<i class="fa-solid fa-sort-up ms-2"></i></a>
                    <a href="?page=1&order=3<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 4) echo "d-block" ?>">庫存數量<i class="fa-solid fa-sort-down ms-2"></i></a>
                </th>
                <th>
                    <a href="?page=1&order=6<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] <= 4) echo "d-block" ?>">價錢<i class="fa-solid fa-sort ms-2"></i></a>
                    <a href="?page=1&order=6<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 5) echo "d-block" ?>">價錢<i class="fa-solid fa-sort-up ms-2"></i></a>
                    <a href="?page=1&order=5<?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 6) echo "d-block" ?>">價錢<i class="fa-solid fa-sort-down ms-2"></i></a>
                </th>
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
                            <?php if ($product["off_time"]) : ?>

                                <div class="sell-out position-absolute z-1"></div>
                            <?php endif; ?>

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
        </table>

        <div class="btn-toolbar justify-content-center pb-3 " role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group" role="group" aria-label="First group">
                <?php if (isset($_GET["page"])) : ?>
                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                        <a type="button" class="btn btn-outline-primary <?php if ((int)$page === $i) echo "active" ?>" href="?page=<?= $i ?><?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["status"]) ? "&status=" . $_GET["status"] : "" ?><?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>"><?= $i ?></a>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>

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

        const brand = document.querySelector("#brand");
        brand.addEventListener("change", (e) => {

            if (e.target.value == 0) {
                location.href = `product-list.php?page=1`;
            } else {
                location.href = `product-list.php?page=1&brand=${e.target.value}<?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>`;
            }


        });
        const category = document.querySelector("#category");
        category.addEventListener("change", (e) => {

            if (e.target.value == 0) {
                location.href = `product-list.php?page=1`;
            } else {
                location.href = `product-list.php?page=1&category=${e.target.value}<?= isset($_GET["min"]) ? "&min=" . $_GET["min"] : "" ?><?= isset($_GET["max"]) ? "&max=" . $_GET["max"] : "" ?><?= isset($_GET["brand"]) ? "&brand=" . $_GET["brand"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>`;
            }


        });
    </script>

</body>

</html>