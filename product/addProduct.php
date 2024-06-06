<?php
require_once("../db_connect_mahjong.php");
session_start();

$sqlBrand = "SELECT * FROM brand";
$resultBrand = $conn->query($sqlBrand);
$rowsBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);

$sqlCategory = "SELECT * FROM product_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <div class="d-flex align-items-start pt-2 flex-column">
            <a href="product-list.php" class="btn btn-primary btn-sm mb-2"><i class="fa-solid fa-left-long me-2"></i>產品列表</a>
            <h1 class="m-0">新增商品</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="doAddProduct.php" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered text-center align-middle">
                        <tr>
                            <th class="form-label">品名</th>
                            <td><input type="text" class="form-control" name="name"></td>
                        </tr>
                        <tr>
                            <th class="form-label">品牌</th>
                            <td><select class="form-select" name="brand" id="">
                                    <?php foreach ($rowsBrand as $brand) : ?>
                                        <option value="<?= $brand["id"] ?>"><?= $brand["name"] ?></option>
                                    <?php endforeach; ?>
                                </select></td>
                        </tr>
                        <tr>
                            <th class="form-label">類別</th>
                            <td><select class="form-select" name="category" id="">
                                    <?php foreach ($rowsCategory as $category) : ?>
                                        <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
                                    <?php endforeach; ?>
                                </select></td>
                        </tr>
                        <tr>
                            <th class="form-label">商品敘述</th>
                            <td><textarea class="form-control" name="content" id="" rows="4"></textarea></td>
                        </tr>
                        <tr>
                            <th class="form-label">照片</th>
                            <td>
                                <input class="form-control" type="file" name="image" id="uploadImage">
                            </td>
                        </tr>
                        <tr>
                            <th class="form-label">數量</th>
                            <td><input type="number" class="form-control" name="quantity"></td>
                        </tr>
                        <tr>
                            <th class="form-label">定價</th>
                            <td><input type="text" class="form-control" name="price"></td>
                        </tr>
                    </table>
                    <?php if (isset($_SESSION["errorMsg"])) : ?>
                        <div class="text-danger py-2"><?= $_SESSION["errorMsg"] ?></div>
                    <?php endif; ?>
                    <button class="btn btn-primary">送出</button>
                </form>
            </div>
            <div class="col-3">
                <h3>預覽圖:</h3>
                <img class="mt-2 img-fluid d-none" src="" alt="" id="image">
            </div>
        </div>
    </div>
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
    </script>

    <?php include("../js-mahjong.php") ?>
</body>

</html>