<?php
session_start();

if (!isset($_POST["username"])) {
    header("Location: login.php");
    exit;
}
$username = $_POST["username"];
$password = $_POST["password"];

?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歡迎頁面</title>
</head>

<body>
    <h2>歡迎, <?php echo $username; ?>!</h2>
    <a href="logout.php">登出</a>
</body>

</html>