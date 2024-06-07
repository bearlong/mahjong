<?php
require_once("../db_connect_mahjong.php");
session_start();

?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <title>新增產品</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("./css.php") ?>
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="container main-content px-5">
        <?php include("./category_fetch.php") ?>

        <h1>新增產品</h1>
        <form action="store_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">產品名稱</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">價格</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">數量</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">內容</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">類別</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($cateRows as $cate) : ?>
                        <option value="<?= $cate['id'] ?>"><?= $cate['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">品牌ID</label>
                <input type="number" class="form-control" id="brand_id" name="brand_id" required>
            </div>
            <div class="mb-3">
                <label for="off_time" class="form-label">下架時間</label>
                <input type="datetime-local" class="form-control" id="off_time" name="off_time" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">圖片上傳</label>
                <input type="file" class="form-control" id="img" name="img" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">提交</button>
        </form>
    </div>
    <?php include("./js.php") ?>
    <?php include("../js-mahjong.php") ?>
</body>

</html>