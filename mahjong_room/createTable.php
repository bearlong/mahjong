<?php
require_once("../db_connect_mahjong.php");

$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id == 0) {
  die("無效的房間 ID");
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>createTable</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php") ?>

  <div class="container main-content px-5">
    <div class="row justify-content-center align-items-center g-2">
      <form action="doCreate_table.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        <div class="col-6 mb-2 mt-2">
          <label for="table_type">大廳/包廂:</label>
          <select name="table_type" class="form-select" aria-label="Default select example">
            <option value="" disabled selected>大廳/包廂</option>
            <option value="1">大廳</option>
            <option value="2">包廂</option>
          </select>
        </div>
        <div class="col-6 mb-2">
          <label for="text" class="form-label">*名稱</label>
          <input type="text" class="form-control" name="name">
        </div>
        <div class="col-6 mb-2">
          <label for="tentacles" class="form-label">*價格</label>
          <input type="number" class="form-control" name="price">
        </div>
        <button class="col-1 btn btn-primary" type="submit">儲存</button>
      </form>

    </div>


  </div>


  <!-- Bootstrap JavaScript Libraries -->
  <?php include("../js-mahjong.php") ?>

</body>

</html>