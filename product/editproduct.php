<?php
require_once("../db_connect_mahjong.php");
session_start();
if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}
$id = $_GET["id"];


$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlBrand = "SELECT * FROM brand";
$resultBrand = $conn->query($sqlBrand);
$rowsBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);

$sqlCategory = "SELECT * FROM product_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);


?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php") ?>
    <style>
        .object-fit-conver {
            width: 100%;
            height: 100%;
        }
    </style>

</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-3">
        <div class="row py-3">
            <div class="col-8">

                <div class="d-flex align-items-start py-2 flex-column">
                    <a href="product.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm mb-2"><i class="fa-solid fa-left-long me-2"></i>商品明細</a>
                    <h2>修改資料</h2>
                </div>
                <div class="row py-2">
                    <form action="doEditProduct.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-2">品名</th>
                                <td class="col-8"><input class="form-control" type="text" name="name" value="<?= $row["name"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="col-2">品牌</th>
                                <td class="col-8">
                                    <select name="brand" class="form-select">
                                        <?php foreach ($rowsBrand as $brand) : ?>
                                            <option value="<?= $brand["id"] ?>" <?php if ($brand["id"] === $row["brand_id"]) {
                                                                                    echo "selected";
                                                                                } ?>><?= $brand["name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>類別</th>
                                <td> <select name="category" class="form-select">
                                        <?php foreach ($rowsCategory as $category) : ?>
                                            <option value="<?= $category["id"] ?>" <?php if ($category["id"] === $row["category_id"]) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $category["name"] ?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <th>商品敘述</th>
                                <td><textarea class="form-control" type="text" name="content" rows="6"><?= $row["content"] ?> </textarea></td>
                            </tr>
                            <tr>
                                <th>庫存數量</th>
                                <td><input class="form-control" type="number" name="quantity" value="<?= $row["quantity"] ?>"></td>
                            </tr>
                            <tr>
                                <th>價錢</th>
                                <td><input class="form-control" type="text" name="price" value="<?= $row["price"] ?>"></td>
                            </tr>
                            <tr>
                                <th>圖片</th>
                                <td><input class="form-control" type="file" name="image" id="uploadImage"></td>
                            </tr>
                        </table>
                        <div class="text-danger pb-2">
                            <?php if (isset($_SESSION["errorMsg"])) : ?>
                                <?= $_SESSION["errorMsg"] ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($row["off_time"]) : ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-truck-ramp-box me-2"></i>上架
                            </button>
                        <?php else : ?>
                            <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk me-2"></i>儲存</button>
                        <?php endif; ?>
                        <div class="d-flex justify-content-start">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4 p-0">
                <img class="img-fluid" src="../images/product/<?= $row["img"] ?>" alt="" id="image">
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        const uploadImage = document.querySelector("#uploadImage");
        const image = document.querySelector("#image");

        uploadImage.addEventListener("change", (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();

            if (image.src) {
                URL.revokeObjectURL(image.src);
            }

            reader.readAsDataURL(file);
            reader.addEventListener("load", () => {
                image.src = reader.result;
                image.classList.remove("d-none");
            });
        });


        for (let i = 0; i < imgBox.length; i++) {
            imgBox[i].addEventListener("click", function() {
                for (let j = 0; j < imgBox.length; j++) {
                    imgBox[j].classList.remove("pic-active");
                }
                this.classList.add("pic-active");
                let imgId = boxContent[i].dataset.id;

                confirm.href = "doDeleteImg.php?id=" + imgId;

            });
        }
    </script>
</body>

</html>