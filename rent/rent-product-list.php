<?php
require_once("../db_connect_mahjong.php");
session_start();
unset($_SESSION["errorMsg"]);
unset($_SESSION["imgId"]);

$sql = "SELECT rent_product.*, rent_category.name AS category_name, rent_price_category.rent_price, rent_price_category.rent_day  FROM rent_product JOIN rent_category ON rent_product.category_id = rent_category.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE 1";
$pageTitle = "租借產品管理列表";

$splAll = "SELECT * FROM rent_product";
$resultAll = $conn->query($splAll);
$allCount = $resultAll->num_rows;

$sqlCategory = "SELECT * FROM rent_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql .= " AND (rent_product.name LIKE '%$search%' OR rent_product.content LIKE '%$search%')";
    $pageTitle = "租借產品 $search 搜尋結果";
}

if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $sql .= " AND rent_product.category_id = $category";
    for ($i = 0; $i < count($rowsCategory); $i++) {
        if ($rowsCategory[$i]["id"] === $category) {
            $pageTitle = "租借產品 " . $rowsCategory[$i]["name"];
        }
    }
}

if (isset($_GET["valid"])) {
    $valid_id = $_GET["valid"];
    $sql .= " AND rent_product.valid = $valid_id";
}

if (isset($_GET["order"])) {
    $order = $_GET["order"];

    switch ($order) {
        case 1:
            $sql .= " ORDER BY rent_product.id ASC";
            break;
        case 2:
            $sql .= " ORDER BY rent_product.id DESC";
            break;
        case 3:
            $sql .= " ORDER BY rent_product.price ASC";
            break;
        case 4:
            $sql .= " ORDER BY rent_product.price DESC";
            break;
        default:
            $sql .= " ORDER BY rent_product.id ASC";
            break;
    }
}
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
    header("location: rent-product-list.php?page=1");
    exit;
}



$resultPage = $conn->query($sqlPage);
// $resultCount = $result->num_rows;
$rows = $resultPage->fetch_all(MYSQLI_ASSOC);



if (!isset($_GET["order"]) && !isset($_GET["valid"]) && !isset($_GET["category"]) && !isset($_GET["search"])) {
    $resultCount = $allCount;
    $pageCount = ceil($allCount / $prepage);
}

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $pageTitle ?></title>
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
            -webkit-line-clamp: 2;
        }

        .sell-out {
            width: 100%;
            height: 100%;
            background: rgba(80, 80, 80, 0.8);

            .sell-out-info {
                font-size: 10px;
                border-radius: 50%;
                background: rgba(120, 120, 120, 0.8);
                width: 60px;
                height: 60px;
                position: absolute;
                top: calc(50% - 30px);
                left: calc(50% - 30px);

                p {
                    margin: 15px 0;
                }

            }
        }

        .order {
            display: none;
        }
    </style>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <h1 class="text-center fw-semibold "><?= $pageTitle ?></h1>

        <div class="py-2 justify-content-between d-flex align-items-center">
            <div>
                <?php if (isset($_GET["search"]) || isset($_GET["category"]) || isset($_GET["order"])) : ?>
                    <a href="rent-product-list.php" class="btn btn-primary btn-sm my-2"><i class="fa-solid fa-left-long me-2"></i>租借產品列表</a>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center">
                <form action="">
                    <div class="input-group position-relative z-0">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon1"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input type="hidden" name="page" value="1">
                        <input type="text" class="form-control" placeholder="search..." aria-label="Example text with button addon" aria-describedby="button-addon1" name="search">
                    </div>
                </form>
                <a href="addProduct.php" class="btn btn-primary ms-3"><i class="fa-solid fa-square-plus me-2"></i>新增</a>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <div>

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

                <div class="mx-3">
                    <p class="text-secondary m-0">共 <?= $resultCount ?> 件商品</p>
                </div>
            </div>
            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if (!isset($_GET["valid"])) echo "active" ?>" aria-current="page" href="rent-product-list.php?page=1<?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">總覽</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php if (isset($_GET["valid"]) && $_GET["valid"] == true) echo "active" ?>" href="?page=1&valid=1<?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">上架中</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (isset($_GET["valid"]) && $_GET["valid"] == false) echo "active" ?>" href="?page=1&valid=0<?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>">已下架</a>
                    </li>
                </ul>
            </div>
        </div>
        <table class="table table-bordered align-middle">
            <thead>
                <tr class="text-nowrap">
                    <th>
                        <a href="?page=1&order=2<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] >= 3) echo "d-block" ?>">id<i class="fa-solid fa-sort ms-2"></i></a>
                        <a href="?page=1&order=2<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 1) echo "d-block" ?>">id<i class="fa-solid fa-sort-up ms-2"></i></a>
                        <a href="?page=1&order=1<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 2) echo "d-block" ?>">id<i class="fa-solid fa-sort-down ms-2"></i></a>
                    </th>
                    <th>品名</th>
                    <th>種類</th>
                    <th>內容</th>
                    <th>主頁圖片</th>
                    <th>庫存數量</th>
                    <th>可出租數量</th>
                    <th>租金類別</th>
                    <th><a href="?page=1&order=4<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (!isset($_GET["order"]) || (int)$_GET["order"] <= 2) echo "d-block" ?>">定價<i class="fa-solid fa-sort ms-2"></i></a>
                        <a href="?page=1&order=4<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 3) echo "d-block" ?>">定價<i class="fa-solid fa-sort-up ms-2"></i></a>
                        <a href="?page=1&order=3<?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="order text-black text-decoration-none <?php if (isset($_GET["order"]) && (int)$_GET["order"] === 4) echo "d-block" ?>">定價<i class="fa-solid fa-sort-down ms-2"></i></a>
                    </th>
                    <th>更多</th>
                </tr>
            </thead>
            <?php foreach ($rows as $rent_product) : ?>
                <tbody>
                    <tr>
                        <td><?= $rent_product["id"] ?></td>
                        <?php if ($rent_product["valid"]) : ?>
                            <td class="fw-semibold"><?= $rent_product["name"] ?></td>
                        <?php else : ?>
                            <td class="text-body-tertiary fw-semibold"><?= $rent_product["name"] ?><span class="text-danger d-block">已下架</span></td>
                        <?php endif; ?>
                        <td class="text-nowrap"><a href="rent-product-list.php?page=1&category=<?= $rent_product["category_id"] ?><?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>" class="text-decoration-none"><?= $rent_product["category_name"] ?></a></td>
                        <td>
                            <div class="content">
                                <?= $rent_product["content"] ?></div>
                        </td>
                        <td>
                            <div class="img-box ratio ratio-4x3 position-relative z-0">
                                <div class="sell-out position-absolute z-1  <?php
                                                                            if ((int)$rent_product["quantity_available"] !== 0) {
                                                                                echo "d-none";
                                                                            }
                                                                            ?>">
                                    <div class="sell-out-info shadow text-body-tertiary text-center">
                                        <p class="p-2"><?= $rent_product["valid"] ? "暫無庫存" : "已下架" ?></p>
                                    </div>
                                </div>
                                <img class="object-fit-cover position-absolute" src="../images/rent_product/<?= $rent_product["id"] ?>/<?= $rent_product["img"] ?>" alt="">
                            </div>
                        </td>
                        <td><?= $rent_product["quantity"] ?></td>
                        <td><?= $rent_product["quantity_available"] ?></td>
                        <td class="text-nowrap"><?= number_format($rent_product["rent_price"]) ?>/<?= $rent_product["rent_day"] ?>天</td>
                        <td><?= number_format($rent_product["price"]) ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <a href="rent-product.php?id=<?= $rent_product["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                                <a href="editProduct.php?id=<?= $rent_product["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="addImg.php?id=<?= $rent_product["id"] ?>" class="btn btn-primary"><i class="fa-regular fa-image"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
        <div class="btn-toolbar justify-content-center pb-3 " role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group" role="group" aria-label="First group">
                <?php if (isset($_GET["page"])) : ?>
                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                        <a type="button" class="btn btn-outline-primary <?php if ((int)$page === $i) echo "active" ?>" href="?page=<?= $i ?><?= isset($_GET["order"]) ? "&order=" . $_GET["order"] : "" ?><?= isset($_GET["valid"]) ? "&valid=" . $_GET["valid"] : "" ?><?= isset($_GET["category"]) ? "&category=" . $_GET["category"] : "" ?><?= isset($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>"><?= $i ?></a>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>

    <script>
        const categroy = document.querySelector("#category");
        const idOrder = document.querySelector("#id-order");
        categroy.addEventListener("change", (e) => {

            if (e.target.value == 0) {
                location.href = `rent-product-list.php?page=1`;
            } else {
                location.href = `rent-product-list.php?page=1&category=${e.target.value}`;
            }


        });
    </script>
</body>

</html>