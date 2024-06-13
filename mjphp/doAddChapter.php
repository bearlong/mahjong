<?php
require_once("../db_connect_mahjong.php");
session_start();
if (!isset($_POST["id"])) {
    echo "請由正確管道進入";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$content = $_POST["content"];
$filesImg = $_FILES['image'];
$filesVideo = $_FILES['video'];
$now = date('Y-m-d H:i:s');


$sqlCourse = "SELECT course.*, course_category.name AS category_name FROM course JOIN course_category ON course_category.id = course.course_category_id WHERE course.id = '$id'";

$resultCourse = $conn->query($sqlCourse);

$rowCourse = $resultCourse->fetch_assoc();

for ($i = 0; $i < count($name); $i++) {
    $nameValue = $name[$i];
    $contentValue = $content[$i];


    $pathImg = "./images/" . $rowCourse["category_name"];
    $pathVideo = "./video/" . $rowCourse["category_name"];
    print_r($files);

    if (!file_exists($pathImg)) {
        mkdir($pathImg, true);
    }
    if (!file_exists($pathVideo)) {
        mkdir($pathVideo, true);
    }


    $nameImg = $filesImg["name"][$i];
    $tmpFileImg = $filesImg["tmp_name"][$i];
    $sizeImg = $filesImg["size"][$i];

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
        echo "上傳成功";
    } else {
        $_SESSION["errorMsg"] = $name . " 圖片上傳失敗";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    $nameVideo = $filesVideo["name"][$i];
    $tmpFileVideo = $filesVideo["tmp_name"][$i];
    $sizeVideo = $filesVideo["size"][$i];

    $targetfilesVideo = $pathVideo . "/" . basename($nameVideo);

    if (file_exists($targetfilesVideo)) {
        $_SESSION["errorMsg"] = $nameVideo . " 已經存在";
        header("location: course-chapter.php?id=$id");
        exit;
    }

    if (move_uploaded_file($tmpFileVideo, $targetfilesVideo)) {
        echo "上傳成功";
    } else {
        $_SESSION["errorMsg"] = $name . " 圖片上傳失敗";
        header("location: course-chapter.php?id=$id");
        exit;
    }


    $sql = "INSERT INTO course_chapter (course_id, chapter_name, content, images, video_url, created_at) VALUES ('$id', '$nameValue', '$contentValue', '$nameImg', '$nameVideo', '$now')";

    if ($conn->query($sql) === TRUE) {
        echo "新資料輸入成功";
        $last_id = $conn->insert_id;
        unset($_SESSION["errorMsg"]);
        header("location: course-detail.php?id=$id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
