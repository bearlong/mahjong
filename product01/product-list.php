<?php
require_once("../db_connect_mahjong.php");
session_start();

$user_id = 6;
$sqlUserLikes = "SELECT * FROM user_like WHERE user_id=$user_id";
$resultUserLikes = $conn->query($sqlUserLikes);
$rowUserLikes = $resultUserLikes->fetch_all(MYSQLI_ASSOC);
// var_dump($rowUserLikes);
$likeArr = [];
foreach ($rowUserLikes as $like) {
    $likeArr[] = $like["product_id"];
}
// var_dump($likeArr);

$sqlCategory = "SELECT * FROM product_category ORDER BY id ASC";
$resultCate = $conn->query($sqlCategory);
$cateRows = $resultCate->fetch_all(MYSQLI_ASSOC);
$categoryArr = [];
foreach ($cateRows as $cate) {
    $categoryArr[$cate["id"]] = $cate["name"];
}

$pageTitle = "產品列表";
if (isset($_GET["min"]) && isset($_GET["max"])) {
    $min = $_GET["min"];
    $max = $_GET["max"];
    // $sql="SELECT * FROM product WHERE price >= $min AND price <=$max";
    $sql = "SELECT product.*, product_category.name AS category_name FROM product 
    JOIN product_category ON product.category_id = product_category.id
    WHERE product.price >= $min AND product.price <=$max
    ORDER BY product.id ASC";
} else if (isset($_GET["category"])) {
    $category_id = $_GET["category"];
    $sql = "SELECT product.*, product_category.name AS category_name FROM product 
    JOIN product_category ON product.category_id = product_category.id
    WHERE product.category_id = $category_id
    ORDER BY product.id ASC";

    $pageTitle = $categoryArr[$category_id] . "產品列表";
} else {
    $sql = "SELECT product.*, product_category.name AS category_name FROM product 
    JOIN product_category ON product.category_id = product_category.id
    ORDER BY product.id ASC";
}

$result = $conn->query($sql);

$productCount = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);
$result_count = $result->num_rows;

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $pageTitle ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("./css.php") ?>
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("nav.php") ?>

    <div class="container main-content px-5">
        <?php include("nav1.php") ?>
        <h1><?= $pageTitle ?></h1>
        <div class="py-2">
            <form action="">
                <div class="row g-3 align-items-center">
                    <?php if (isset($_GET["min"])) : ?>
                        <div class="col-auto">
                            <a class="btn btn-primary" href="product-list.php"><i class="fa-solid fa-arrow-left"></i></a>
                        </div>
                    <?php endif; ?>
                    <?php
                    $minValue = 0;
                    $maxValue = 9999;
                    if (isset($_GET["min"])) $minValue = $_GET["min"];
                    if (isset($_GET["max"])) $maxValue = $_GET["max"];

                    ?>
                    <div class="col-auto">
                        價格篩選
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control text-end" value="<?= $minValue ?>" name="min" min="0">
                    </div>
                    <div class="col-auto">
                        ~
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control text-end" value="<?= $maxValue ?>" name="max" min="0">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="py-2">
            共 <?= $result_count ?> 筆
        </div>
        <div class="row g-3">
            <?php foreach ($rows as $product) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="ratio ratio-1x1 position-relative">
                        <img class="object-fit-cover" src="/images/<?= $product["img"] ?>" alt="<?= $product["name"] ?>">
                        <div>
                            <span class="position-absolute favorite-icon <?php
                                                                            if (in_array($product["id"], $likeArr)) {
                                                                                echo "active";
                                                                            }
                                                                            ?>">
                                <i class="fa-solid fa-heart"></i>
                            </span>
                        </div>
                    </div>
                    <div class="pt-2 text-primary">
                        <a class="text-decoration-none" href="?category=<?= $product["category_id"] ?>"><?= $product["category_name"] ?></a>
                    </div>
                    <h3>
                        <a href="product.php?id=<?= $product["id"] ?>"><?= $product["name"] ?></a>
                    </h3>
                    <div class="text-end fs-4 text-danger">$<?= $product["price"] ?></div>
                    <div class="d-grid">
                        <button class="btn btn-primary add-cart" data-id="<?= $product["id"] ?>">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include("../js.php") ?>
    <script>
        const addCartBtns = document.querySelectorAll(".add-cart")
        const cartCount = document.querySelector("#cartCount");
        // console.log(addCartBtns);
        for (let i = 0; i < addCartBtns.length; i++) {
            addCartBtns[i].addEventListener("click", function() {
                let id = this.dataset.id;
                // console.log(id);
                $.ajax({
                        method: "POST", //or GET
                        url: "http://localhost:8080/api/addCart.php",
                        dataType: "json",
                        data: {
                            id: id,
                        }
                    })
                    .done(function(response) {
                        //    console.log(response);
                        cartCount.textContent = response.length;

                    }).fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
            })
        }
    </script>
    <?php include("../js-mahjong.php") ?>

</body>

</html>