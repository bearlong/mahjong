<?php
if (!isset($_GET["id"])) {
  $id = 1;
} else {
  $id = $_GET["id"];
}

require_once("../db_connect_mahjong.php");


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

// $userExit = true;
// if ($result->num_rows == 0) {
//   $userExit = false;
// }

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
  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">確認刪除</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          確認刪除使用者?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <a href="user-delete.php?id=<?= $row["id"] ?>" type="button" class="btn btn-danger">確認</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container ">
    <div class="py-2">
      <a class="btn btn-primary" href="users.php"><i class="fa-solid fa-arrow-left"></i> 回使用者列表
      </a>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-4">
        <?php if ($result->num_rows > 0) : ?>
          <table class="table table-bordered">
            <tr>
              <th>id</th>
              <td><?= $row["id"] ?> </td>
            </tr>
            <tr>
              <th>username</th>
              <td><?= $row["username"] ?></td>
            </tr>
            <tr>
              <th>account</th>
              <td><?= $row["account"] ?></td>
            </tr>
            <tr>
              <th>password</th>
              <td><?= $row["password"] ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?= $row["Address"] ?></td>
            </tr>
            <tr>
              <th>birth</th>
              <td><?= $row["birth"] ?></td>
            </tr>
            <tr>
              <th>gender</th>
              <td><?= $row["gender"] ?></td>
            </tr>
            <tr>
              <th>email</th>
              <td><?= $row["email"] ?></td>
            </tr>
            <tr>
              <th>phone</th>
              <td><?= $row["phone"] ?></td>
            </tr>
            <tr>
              <th>create time</th>
              <td><?= $row["created_at"] ?></td>
            </tr>
          </table>

          <div class="py-2 d-flex justify-content-between">
            <a href="user-edit.php?id=<?= $row["id"] ?> " title="編輯使用者" class="btn btn-primary">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>

            <a class="btn btn-danger" title="刪除使用者" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash-can"></i></a>
          </div>
        <?php else : ?>
          <h1>使用者不存在</h1>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <?php include("../js-mahjong.php") ?>
</body>

</html>