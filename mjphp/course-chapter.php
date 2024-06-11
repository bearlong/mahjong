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
    <div class="container">
        <h1>章節編輯</h1>
        <button class="btn btn-primary my-2" id="plus"><i class="fa-solid fa-plus"></i></button>
        <form action="">
            <table class="table table-bordered" id="form-td">
                <tr>
                    <th>章節名稱</th>
                    <th>章節簡述</th>
                    <th>上傳影片</th>
                    <th>章節圖</th>
                </tr>
                <?php if ($resultChap->num_rows == 0) : ?>
                    <tr>
                        <td>
                            <input type="text" name="name" class="form-control">
                        </td>
                        <td>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                        </td>
                        <td>
                            <input type="file" name="video" class="form-control">
                        </td>
                        <td>
                            <input type="file" name="image" class="form-control">
                        </td>
                        <td>
                            預覽圖:
                            <img src="" alt="">
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($rows as $chapter) : ?>
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
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </table>
        </form>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script>
        const plus = document.querySelector("#plus");
        const formTd = document.querySelector("#form-td");
        plus.addEventListener("click", function() {
            formTd.insertAdjacentHTML('beforeend', '<tr><td><input type="text" name="name" class="form-control"></td><td><textarea name="content" class="form-control" rows="3"></textarea> </td><td><input type="file" name="video" class="form-control"></td><td><input type="file" name="image" class="form-control uploadImage"></td><td>預覽圖:<img  class="img-thumbnail d-none image" src="" alt=""></td></tr>');
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
    </script>
    <?php include("../js-mahjong.php") ?>

</body>

</html>