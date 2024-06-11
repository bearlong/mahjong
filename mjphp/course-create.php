<?php
session_start();
require_once("../db_connect_mahjong.php");
$sql = "SELECT * FROM course_category";

$result = $conn->query($sql);

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course-upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include("../css_mj.php"); ?>
    <?php include("../css-mahjong.php"); ?>

    <style>
        /* 全局樣式調整 */


        /* 表單樣式調整 */
        .form-label {
            font-weight: bold;
        }

        /* 影片和圖片輸入欄樣式調整 */
        input[type="file"] {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <?php include("../nav.php"); ?>

    <div class="container main-content px-5">
        <a class="btn btn-primary my-2" href="course-list.php">回列表 <i class="fa-solid fa-arrow-left"></i></a>
        <h1 class="text-center mb-5">課程上傳</h1>

        <div class="row">
            <div class="col-md-6">
                <form action="doCreateCourse.php" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="course_name" class="form-label">*課程名稱</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">*課程價格</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_category_id" class="form-label">*類別</label>
                        <select id="course_category_id" name="course_category_id" class="form-select" required>
                            <?php foreach ($rows as $row) : ?>
                                <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="on_datetime" class="form-label">*上架時間</label>
                        <input type="date" class="form-control" id="on_datetime" name="on_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="off_datetime" class="form-label">*下架時間</label>
                        <input type="date" class="form-control" id="off_datetime" name="off_datetime" required>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="content" class="form-label">*課程介紹</label>
                    <textarea name="content" id="content" rows="4" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">*上傳預告影片</label>
                    <input type="file" class="form-control" id="file" name="file" accept="video/*" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">*上傳圖片</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-info">送出</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("../js-mahjong.php"); ?>

</body>

</html>