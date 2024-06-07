<?php
require_once("../db_connect_mahjong.php");
session_start();
$id = $_GET["id"];
$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <title>編輯產品</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <?php include("./css.php") ?>
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <?php include("category_fetch.php") ?>
        <h1>編輯產品</h1>
        <form action="update_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product["id"] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">產品名稱</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product["name"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">價格</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product["price"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">描述</label>
                <textarea class="form-control" id="content" name="content" rows="3" required><?= $product["content"] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">類別</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($cateRows as $cate) : ?>
                        <option value="<?= $cate['id'] ?>" <?= $cate['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $cate['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">品牌 ID</label>
                <input type="number" class="form-control" id="brand_id" name="brand_id" value="<?= $product["brand_id"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">產品圖片</label>
                <input type="file" class="form-control" id="img" name="img">
                <?php if ($product["img"]) : ?>
                    <img src="../uploads/<?= $product["img"] ?>" alt="<?= $product["name"] ?>" style="width:100px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
    <?php include("./js.php") ?>
    <?php include("../js-mahjong.php") ?>

</body>

</html>