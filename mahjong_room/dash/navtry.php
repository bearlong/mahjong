<?php
session_start();

if (!isset($_POST["group"])) {
    $data = [
        "message" => "沒有帶入正確參數"
    ];
    echo json_encode($data);
    exit;
}

$group = $_POST["group"];
$_SESSION["group"] = $group;

$data = [
    "status" => 1,
    "group" => $group
];
echo json_encode($data);
