<?php

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

require_once("../db_connect_mahjong.php");

$sql = "SELECT * FROM course WHERE id = $id AND valid=1";
// echo $sql;
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $courseExit = true;
    $title = $row["course_name"];
} else {
    $courseExit = false;
    $title = "課程不存在";
}

$sqlCategory = "SELECT course.*, course_category.name AS category_name 
        FROM course 
        JOIN course_category ON course.course_category_id = course_category.id
        WHERE course.id = $id AND course.valid=1";

$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);
$categoryCount = $resultCategory->num_rows;

// $courseExit=true;
// if($result->num_rows==0){$courseExit=false;}
// var_dump($row);
?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css-mahjong.php"); ?>

</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLable">確認刪除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認刪除課程?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="doDeleteCourse.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
                </div>
            </div>
        </div>
    </div>
    <?php include("../nav.php"); ?>

    <div class="container main-content px-5">
        <h1 class="my-4">課程資訊</h1>
        <div class="py-2">
            <a class="btn btn-primary" href="course-list.php"><i class="fa-solid fa-arrow-left"></i> 回課程列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <?php if ($courseExit) : ?>
                    <table class="table table-bordered">
                        
                        <tr>
                            <th>id</th>
                            <td><?= $row["id"] ?></td>
                        </tr>
                        <tr>
                            <th>course_name</th>
                            <td><?= $row["course_name"] ?></td>
                        </tr>
                        <tr>
                        <th>category_name</th>
                        <td><?= $rowsCategory[0]["category_name"] ?></td>
                        </tr>
                        <tr>
                            <th>images</th>
                            <td><?= $row["images"] ?></td>
                        </tr>
                        <tr>
                            <th>file</th>
                            <td><?= $row["file"] ?></td>
                        </tr>
                        <tr>
                            <th>price</th>
                            <td><?= $row["price"] ?></td>
                        </tr>
                        <tr>
                            <th>on_datetime</th>
                            <td><?= $row["on_datetime"] ?></td>
                        </tr>
                        <tr>
                            <th>off_datetime</th>
                            <td><?= $row["off_datetime"] ?></td>
                        </tr>
                    </table>
                    <div class="py-2 d-flex justify-content-between">
                        <a class="btn btn-primary" href="course-edit.php?id=<?= $row["id"] ?>" title="編輯課程">編輯 <i class="fa-solid fa-pen-to-square"></i></a>

                        <button class="btn btn-danger" title="刪除課程" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                <?php else : ?>
                    <h1>課程不存在</h1>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <?php include("../js-mahjong.php"); ?>

</body>

</html>