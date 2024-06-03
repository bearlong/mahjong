<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_POST["id"])) {
    echo "請於正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$sql = "SELECT * FROM rent_product WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (isset($_FILES["images"]) && $_FILES["images"]["error"][0] === 0) {
    $files = $_FILES['images'];

    $path = "../images/rent_product/" . $row["id"];
    print_r($files);

    if (!file_exists($path)) {
        mkdir($path, true);
    }

    for ($i = 0; $i < count($files["name"]); $i++) {
        $name = $files["name"][$i];
        $tmpFile = $files["tmp_name"][$i];
        $size = $files["size"][$i];

        $checkImg = getimagesize($tmpFile);

        if ($checkImg === false) {
            $_SESSION["errorMsg"] = $name . " 上傳的不是圖片";
            header("location: addImg.php?id=$id");
            exit;
        }

        if ($size > 2000000) {
            $_SESSION["errorMsg"] = $name . " 圖檔不能大於2MB";
            header("location: addImg.php?id=$id");
            exit;
        }
    }

    foreach ($files["name"] as $key => $name) {
        $targetfiles = $path . "/" . basename($name);
        $tmpFile = $files['tmp_name'][$key];

        if (file_exists($targetfiles)) {
            $_SESSION["errorMsg"] = $name . " 已經存在";
            header("location: addImg.php?id=$id");
            exit;
        }

        if (move_uploaded_file($tmpFile, $targetfiles)) {
            echo "上傳成功";
            $sqlImg = "INSERT INTO rent_images (rent_product_id, url) VALUES ('$id', '$name')";
            unset($_SESSION["errorMsg"]);
            if ($conn->query($sqlImg) === TRUE) {
            }
        } else {
            $_SESSION["errorMsg"] = $name . " 圖片上傳失敗";
            header("location: addImg.php?id=$id");
            exit;
        }
    }

    header("location: addImg.php?id=$id");
} else {
    $_SESSION["errorMsg"] = "請選擇圖片";
    header("location: addImg.php?id=$id");
    exit;
}
