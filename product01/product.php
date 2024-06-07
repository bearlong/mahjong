<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_GET["id"])) {
    header("location: product-list.php");
}
$sqlCategory = "SELECT * FROM category ORDER BY id ASC";
$resultCate = $conn->query($sqlCategory);
$cateRows = $resultCate->fetch_all(MYSQLI_ASSOC);

$id = $_GET["id"];
$sql = "SELECT product.*, category.name AS category_name FROM product 
JOIN category ON product.category_id = category.id 
WHERE product.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlLikedUser = "SELECT user_like.*, users.name FROM user_like
JOIN users ON user_like.user_id = users.id
WHERE user_like.product_id=$id
";
$resultLiked = $conn->query($sqlLikedUser);
$rowsLiked = $resultLiked->fetch_all(MYSQLI_ASSOC);
// var_dump($rowsLiked);

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $row["name"] ?></title>
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
        <div class="row g-3">
            <div class="col-lg-6">
                <img class="img-fluid" src="/images/<?= $row["img"] ?>" alt="<?= $row["name"] ?>">
            </div>
            <div class="col-lg-6">
                <div class="pt-2 text-primary">
                    <a class="text-decoration-none" href="product-list.php?category=<?= $row["category_id"] ?>"><?= $row["category_name"] ?></a>
                </div>
                <h1><?= $row["name"] ?></h1>
                <div class="text-danger fs-2 text-end">$<?= number_format($row["price"]) ?></div>
                <h3>收藏者</h3>
                <ul>
                    <?php foreach ($rowsLiked as $user) : ?>
                        <li><?= $user["name"] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>

</body>

</html>