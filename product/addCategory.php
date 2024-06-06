<?php
require_once("../db_connect_mahjong.php");
session_start();

$sql = "SELECT * FROM product_category WHERE valid = 1 ORDER BY id DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>品牌管理</title>
    <?php include("../css-mahjong.php") ?>
    <style>
        .list-item {
            color: #000;

        }

        .list-item:hover {
            background: #0D6EFD;
            cursor: pointer;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include("../nav.php") ?>
    <div class="modal fade" id="deleteBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">確認刪除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確定要刪除嗎?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="" type="button" class="btn btn-danger" id="confirm">確認</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-content px-5">
        <a href="product-list.php?page=1" class="btn btn-primary my-2"><i class="fa-solid fa-left-long me-2"></i>回列表</a>
        <h1>類別管理</h1>
        <div class="row justify-content-center">
            <div class="col-4">
                <h3 class="mb-2">新增類別</h3>
                <form action="doAddCategory.php" method="post">
                    <table class="table table-bordered">
                        <tr>
                            <th>類別名稱</th>
                            <th><input type="text" name="name" class="form-control"></th>
                        </tr>
                    </table>
                    <button class="btn btn-primary">送出</button>
                </form>
            </div>
            <div class="col-4">
                <h3 class="mb-2">刪除類別</h3>
                <ul class="list-group">
                    <?php foreach ($rows as $category) : ?>
                        <li class="list-group-item list-item deleteBtn" data-id="doDeleteCategory.php?id=<?= $category["id"] ?>" data-bs-toggle="modal" data-bs-target="#deleteBackdrop"><?= $category["name"] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <script>
        const deleteBtn = document.querySelectorAll('.deleteBtn');
        const confirm = document.querySelector('#confirm');

        for (let i = 0; i < deleteBtn.length; i++) {

            deleteBtn[i].addEventListener("click", function() {
                let id = deleteBtn[i].dataset.id;
                confirm.href = id;
            })
        }
    </script>
    <?php include("../js-mahjong.php") ?>
</body>

</html>