<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_GET["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_GET["id"];

$sqlChap = "SELECT * FROM course_chapter WHERE course_id = $id";

$resultChap = $conn->query($sqlChap);

$rows = $resultChap->fetch_all(MYSQLI_ASSOC);

$sqlCourse = "SELECT * FROM course WHERE id = $id";

$resultCourse = $conn->query($sqlCourse);

$rowCourse = $resultCourse->fetch_assoc();

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
        img {
            width: 100px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modalTriggerButton">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel">課程尚未有章節</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    請依序填入章節名稱、簡述、影片及預覽圖。
                    <br>
                    按下"+"號可新增下一個章節。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>章節編輯</h1>
        <div class="py-2">
            <a class="btn btn-primary" href="course-detail.php?id=<?= $id ?>"><i class="fa-solid fa-arrow-left"></i> 回課程</a>
        </div>
        <button class="btn btn-primary my-2" id="plus"><i class="fa-solid fa-plus"></i></button>
        <table class="table table-bordered">
            <?php if ($resultChap->num_rows != 0) : ?>
                <tr>
                    <th>章節名稱</th>
                    <th>章節簡述</th>
                    <th>上傳影片</th>
                    <th>章節圖</th>
                </tr>
                <?php foreach ($rows as $chapter) : ?>
                    <form action="doEditChapter.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" class="form-control" value="<?= $chapter["id"] ?>">
                        <tr>
                            <td>
                                <input type="text" name="name" class="form-control" value="<?= $chapter["chapter_name"] ?>">
                            </td>
                            <td>
                                <textarea name="content" class="form-control" rows="3"><?= $chapter["content"] ?></textarea>
                            </td>
                            <td>
                                <input type="file" name="video" class="form-control">
                            </td>
                            <td>
                                <input type="file" name="image" class="form-control uploadImage">
                            </td>
                            <td>
                                預覽圖:
                                <img class="img-thumbnail image" src="./images/Mahjong/<?= $chapter["images"] ?>" alt="">
                            </td>
                            <td>
                                <button class="btn btn-primary my-3"><i class="fa-solid fa-pen-to-square"></i></button>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <form action="doAddChapter.php" method="post" enctype="multipart/form-data">
        <table class="table table-bordered" id="form-td">
            <tr>
                <th>章節名稱</th>
                <th>章節簡述</th>
                <th>上傳影片</th>
                <th>章節圖</th>
            </tr>
            <input type="hidden" name="id" class="form-control" value="<?= $id ?>">
            <tr>
                <td>
                    <input type="text" name="name[]" class="form-control">
                </td>
                <td>
                    <textarea name="content[]" class="form-control" rows="3"></textarea>
                </td>
                <td>
                    <input type="file" name="video[]" class="form-control">
                </td>
                <td>
                    <input type="file" name="image[]" class="form-control uploadImage">
                </td>
                <td>
                    預覽圖:
                    <img class="img-thumbnail image d-none" src="" alt="">
                </td>
            </tr>
        </table>
        <button class="btn btn-primary my-3">送出</button>
    </form>


    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js-mahjong.php") ?>

    <script>
        const plus = document.querySelector("#plus");
        const formTd = document.querySelector("#form-td");
        plus.addEventListener("click", function() {
            formTd.insertAdjacentHTML('beforeend', '<tr><td><input type="text" name="name[]" class="form-control"></td><td><textarea name="content[]" class="form-control" rows="3"></textarea> </td><td><input type="file" name="video[]" class="form-control"></td><td><input type="file" name="image[]" class="form-control uploadImage"></td><td>預覽圖:<img  class="img-thumbnail d-none image" src="" alt=""></td></tr>');
        });

        formTd.addEventListener("change", (e) => {
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

        <?php if ($resultChap->num_rows == 0) : ?>
            var modalTriggerButton = document.getElementById('modalTriggerButton');
            if (modalTriggerButton) {
                modalTriggerButton.click();
            }

        <?php endif; ?>
    </script>

</body>

</html>