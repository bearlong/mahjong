<?php
require_once("../db_connect_mahjong.php");
session_start();
$id = $_POST['id'];
$name = $_POST['name'];
$content = $_POST['content'];
$now = date('Y-m-d H:i:s');

$sqlCourse = "SELECT course_chapter.*, course_category.name AS category_name, course.course_category_id FROM course_chapter JOIN course ON course.id = course_chapter.course_id JOIN course_category ON course_category.id = course.course_category_id WHERE course_chapter.id = '$id'";

$resultCourse = $conn->query($sqlCourse);

$rowCourse = $resultCourse->fetch_assoc();

if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {

    $filesImg = $_FILES['image'];
    $pathImg = "./images/" . $rowCourse["category_name"];

    if (!file_exists($pathImg)) {
        mkdir($pathImg, true);
    }

    $nameImg = $filesImg["name"];
    $tmpFileImg = $filesImg["tmp_name"];
    $sizeImg = $filesImg["size"];

    $checkImg = getimagesize($tmpFileImg);

    if ($checkImg === false) {
        $_SESSION["errorMsg"] = $nameImgame . " 上傳的不是圖片";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    if ($sizeImg > 2000000) {
        $_SESSION["errorMsg"] = $nameImgame . " 圖檔不能大於2MB";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    $targetfilesImg = $pathImg . "/" . basename($nameImg);

    if (file_exists($targetfilesImg)) {
        $_SESSION["errorMsg"] = $nameImg . " 已經存在";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    if (move_uploaded_file($tmpFileImg, $targetfilesImg)) {
        $pathDImg = "./images/" . $rowCourse["category_name"] . "/" . $rowCourse["images"];

        if (file_exists($pathDImg)) {
            unlink($pathDImg);
        };

        echo "上傳成功";
        $sqlImg = "UPDATE `course_chapter` SET images = '$nameImg' WHERE `course_chapter`.`id` = $id";;
        unset($_SESSION["errorMsg"]);
        if ($conn->query($sqlImg) === TRUE) {
        }
    } else {
        $_SESSION["errorMsg"] = $name . " 圖片上傳失敗";
        header("location: course-chapter.php?id=$id");
        exit;
    }
}

if (isset($_FILES['video']) && $_FILES['video']["error"] === 0) {

    $filesVideo = $_FILES['video'];
    $pathVideo = "./video/" . $rowCourse["category_name"];

    if (!file_exists($pathVideo)) {
        mkdir($pathVideo, true);
    }

    $nameVideo = $filesVideo["name"];
    $tmpFileVideo = $filesVideo["tmp_name"];
    $sizeVideo = $filesVideo["size"];


    $targetfilesVideo = $pathVideo . "/" . basename($nameVideo);

    if (file_exists($targetfilesVideo)) {
        $_SESSION["errorMsg"] = $nameVideo . " 已經存在";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    if (move_uploaded_file($tmpFileVideo, $targetfilesVideo)) {
        $pathDVideo = "./video/" . $rowCourse["category_name"] . "/" . $rowCourse["video_url"];

        if (file_exists($pathDVideo)) {
            unlink($pathDVideo);
        };

        echo "上傳成功";
        $sqlVideo = "UPDATE `course_chapter` SET video_url = '$nameVideo' WHERE `course_chapter`.`id` = $id";;
        unset($_SESSION["errorMsg"]);
        if ($conn->query($sqlVideo) === TRUE) {
        }
    } else {
        $_SESSION["errorMsg"] = $name . " 圖片上傳失敗";
        header("location: course-chapter.php?id=$id");
        exit;
    }
}

$pathVideo = "./video/" . $rowCourse["category_name"];



if (!file_exists($pathVideo)) {
    mkdir($pathVideo, true);
}



$sql = "UPDATE course_chapter SET chapter_name = '$name', content = '$content', updated_at = '$now'  WHERE `course_chapter`.`id` = $id";

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
    unset($_SESSION["errorMsg"]);
    header("location: course-detail.php?id=$id");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
