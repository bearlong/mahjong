<?php
require_once("../db_connect_mahjong.php");
session_start();
if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_GET["id"];
$sql = "SELECT * FROM rent_product WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlImg = "SELECT * FROM rent_images WHERE rent_product_id = $id";
$resultImg = $conn->query($sqlImg);
$rowsImg = $resultImg->fetch_all(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $row["name"] ?> 管理圖片</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css-mahjong.php") ?>

    <style>
        .img-prevbox {
            width: 200px;
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
        }

        .img-box {
            border: 8px solid transparent;

            &:hover {
                border: 8px solid red;
            }
        }

        .pic-active {
            border: 8px solid red;
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
                    <a href="addImg.php?id=<?= $id ?>" type="button" class="btn btn-secondary">取消</a>
                    <a href="" type="button" class="btn btn-danger" id="confirm">確認</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-content">
        <div class="d-flex align-items-start py-2 flex-column">
            <a href="rent-product-list.php" class="btn btn-primary btn-sm mb-2"><i class="fa-solid fa-left-long me-2"></i>租借產品列表</a>
            <h1 class="m-0"><?= $row["name"] ?> 管理圖片</h1>
        </div>
        <button class="btn btn-primary my-2" id="plus"><i class="fa-solid fa-plus"></i></button>
        <form action="doAddImg.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row["id"] ?>">
            <table class="table table-bordered" id="img-form">
                <tr>
                    <th class="text-center">圖片</th>
                    <td><input class="form-control uploadImage" type="file" name="images[]" multiple></td>
                    <td>
                        <div class="img-prevbox">
                            預覽圖: <img class="mt-2 object-fit-cover d-none image" src="" alt="">
                        </div>
                    </td>
                </tr>
            </table>
            <?php if (isset($_SESSION["errorMsg"])) : ?>
                <div class="text-danger "><?= $_SESSION["errorMsg"] ?></div>
            <?php endif; ?>
            <button class="btn btn-primary" type="submit"><i class="fa-regular fa-images me-2"></i>新增</button>
        </form>
        <h3 class="mt-4">點選刪除圖庫圖片:</h3>
        <div class="row row-cols-4 g-3 my-3">
            <?php foreach ($rowsImg as $image) : ?>
                <div class="col">
                    <div class="ratio ratio-1x1 img-box" data-bs-toggle="modal" data-bs-target="#deleteBackdrop">
                        <img data-id="<?= $image["id"] ?>" class="object-fit-cover box-content" src="../images/rent_product/<?= $row["id"] ?>/<?= $image["url"] ?>" alt="">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>
    <script>
        const plus = document.querySelector("#plus");
        const imgForm = document.querySelector("#img-form");
        const imgBox = document.querySelectorAll(".img-box");
        const boxContent = document.querySelectorAll(".box-content");
        const confirm = document.querySelector("#confirm");

        plus.addEventListener("click", function() {
            imgForm.insertAdjacentHTML('beforeend', '<tr><th class="text-center">圖片</th><td><input class="form-control uploadImage" type="file" name="images[]" multiple></td><td><div class="img-prevbox">預覽圖: <img class="mt-2 object-fit-cover d-none image" src="" alt=""></div></td></tr>');
        });


        imgForm.addEventListener("change", (e) => {
            if (e.target.classList.contains("uploadImage")) {
                const fileInput = e.target;
                const file = fileInput.files[0];
                const reader = new FileReader();
                const img = fileInput.closest("tr").querySelector(".image");

                reader.readAsDataURL(file);
                reader.addEventListener("load", () => {
                    img.src = reader.result;
                    img.classList.remove("d-none");
                });
            }
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