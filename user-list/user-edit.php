<?php
if (!isset($_GET["id"])) {
  $id = 1;
} else {
  $id = $_GET["id"];
}

require_once("../db_connect_mahjong.php");
session_start();


$sql = "SELECT * FROM users WHERE id = $id AND valid = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
  $userExit = true;
  $title = $row["username"];
} else {
  $userExit = false;
  $title = "使用者不存在";
}

?>
<!doctype html>
<html lang="en">

<head>
  <title><?= $title ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("../css-mahjong.php") ?>

</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content">
    <div class="py-2">
      <a class="btn btn-primary" href="user.php?id=<?= $id ?>""><i class=" fa-solid fa-arrow-left"></i> 回使用者
      </a>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-4">
        <?php if ($userExit) : ?>
          <form action="doUpdateUser.php" method="post">
            <table class="table table-bordered">
              <input type="hidden" name="id" value="<?= $row["id"] ?>">
              <tr>
                <th>id</th>
                <td>
                  <?= $row["id"] ?></td>
              </tr>
              <tr>
                <th>名稱</th>
                <td><input type="text" class="form-control" name="username" value="<?= $row["username"] ?>"></td>
              </tr>
              <tr>
                <th>帳號</th>
                <td><?= $row["account"] ?></td>
              </tr>
              <tr>
                <th>地址</th>
                <td><input type="text" class="form-control" name="Address" value="<?= $row["Address"] ?>"></td>
              </tr>
              <tr>
                <th>生日</th>
                <td><input type="text" class="form-control" name="birth" value="<?= $row["birth"] ?>"></td>
              </tr>
              <tr>
                <th>email</th>
                <td><input type="email" class="form-control" name="email" value="<?= $row["email"] ?>"></td>
              </tr>
              <tr>
                <th>電話</th>
                <td><input type="tel" class="form-control" name="phone" value="<?= $row["phone"] ?>"></td>
              </tr>

            </table>

            <button class="btn btn-primary" type="submit">送出</button>
          </form>
        <?php else : ?>
          <h1>使用者不存在</h1>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php include("../js-mahjong.php") ?>
</body>

</html>