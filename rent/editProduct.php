<?php
require_once("../db_connect_mahjong.php");

session_start();

if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_GET["id"];
$sql  = "SELECT rent_product.*, category.name AS category_name, rent_price_category.rent_price, rent_price_category.rent_day, rent_price_category.range  FROM rent_product JOIN category ON rent_product.category_id = category.id JOIN rent_price_category ON rent_product.rent_price_category_id = rent_price_category.id WHERE rent_product.id = $id";
$result = $conn->query($sql);
$productCount = $result->num_rows;
$row = $result->fetch_assoc();

$sqlCategory = "SELECT * FROM category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

$sqlImg = "SELECT * FROM rent_images WHERE rent_product_id = $id";
$resultImg = $conn->query($sqlImg);
$rowsImg = $resultImg->fetch_all(MYSQLI_ASSOC);

$sqlRentPriceCategory = "SELECT * FROM rent_price_category";
$resultRentPriceCategory = $conn->query($sqlRentPriceCategory);
$rowsRentPriceCategory = $resultRentPriceCategory->fetch_all(MYSQLI_ASSOC);

$title = "修改資料";
if ($productCount > 0) {
    $productExist = true;
} else {
    $productExist = false;
    $title =  "無此產品";
}
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
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
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
                        <a href="doDeleteProduct.php?id=<?= $id ?>" type="button" class="btn btn-danger">確認</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="rent-product-list.php" class="btn btn-primary btn-sm my-2"><i class="fa-solid fa-left-long me-2"></i>租借產品列表</a>
        <?php if ($productExist) : ?>
            <div class="row g-3">
                <div class="col-6">
                    <h1><?= $title ?></h1>
                    <form action="<?php echo $row["valid"] ? "doEditProduct.php" : "doReAddProduct.php" ?>" class="my-4" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" name="id" value="<?= $row["id"] ?>">
                        <table class="table table-bordered">
                            <tr>
                                <th class="form-label">名稱</th>
                                <td><input type="text" class="form-control" name="name" value="<?= $row["name"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="form-label">類別</th>
                                <td><select class="form-select" name="category" id="">
                                        <?php foreach ($rowsCategory as $category) : ?>
                                            <option value="<?= $category["id"] ?>" <?php if ($category["id"] === $row["category_id"]) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $category["name"] ?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <th class="form-label">內容</th>
                                <td><textarea class="form-control" name="content" id="" rows="6"><?= $row["content"] ?></textarea></td>
                            </tr>
                            <tr>
                                <th class="form-label">主頁圖片</th>
                                <td><select class="form-select" name="image" id="changeImage">
                                        <?php foreach ($rowsImg as $img) : ?>
                                            <option value="<?= $img["url"] ?>" <?php if ($img["url"] === $row["img"]) {
                                                                                    echo "selected";
                                                                                } ?>><?= $img["url"] ?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                                <!-- <td><input class="form-control" type="file" name="image" id="uploadImage"></td> -->
                            </tr>
                            <tr>
                                <th class="form-label">庫存</th>
                                <td><input type="number" class="form-control" name="quantity" value="<?= $row["quantity"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="form-label">租金類別</th>
                                <td><select class="form-select" id="" name="rent_price">
                                        <?php foreach ($rowsRentPriceCategory as $rentPriceCategory) : ?>
                                            <option value="<?= $rentPriceCategory["id"] ?>" <?php if ($rentPriceCategory["id"] === $row["rent_price_category_id"]) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $rentPriceCategory["range"] ?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <th class="form-label">定價</th>
                                <td><input type="text" class="form-control" name="price" value="<?= $row["price"] ?>"></td>
                            </tr>
                        </table>
                        <?php if (isset($_SESSION["errorMsg"])) : ?>
                            <div class="text-danger pb-2"><?= $_SESSION["errorMsg"] ?></div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between">
                            <?php if ($row["valid"]) : ?>
                                <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-2"></i>儲存</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBackdrop">
                                    <i class="fa-solid fa-trash me-2"></i>下架
                                </button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-truck-ramp-box me-2"></i>上架
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <div class="mt-5 pt-4">
                        <h3>預覽圖:</h3>
                        <img class="img-fluid" src="../images/rent_product/<?= $row["id"] ?>/<?= $row["img"] ?>" alt="" id="image">
                    </div>
                </div>
            </div>
        <?php else : ?>
            <h1><?= $title ?></h1>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        const changeImage = document.querySelector("#changeImage");
        const image = document.querySelector("#image");

        changeImage.addEventListener("change", () => {
            image.src = "../images/rent_product/<?= $row['id'] ?>/" + changeImage.value;
        });
    </script>
</body>

</html>