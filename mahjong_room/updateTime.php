<?php
require_once("../db_connect_mahjong.php");
session_start();

$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id == 0) {
  die("無效的房間 ID");
}


$sql = "SELECT open_time, close_time FROM mahjong_room WHERE room_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$open_time = $row['open_time'];
$close_time = $row['close_time'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>updateTime</title>
  <?php include("../css-mahjong.php") ?>

</head>

<body>
  <?php include("../nav.php") ?>

  <div class="container main-content px-5">
    <a href="roomDetails.php?room_id=<?php echo htmlspecialchars($room_id); ?>" class="btn btn-primary my-2">返回上一頁</a>
    <div class="row justify-content-center align-items-center g-2">

      <form action="doUpdateTime.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

        <div class="col-6 mb-2">
          <label for="open_time" class="form-label">*營業時間</label>
          <input type="time" class="form-control" name="open_time" value="<?php echo $open_time; ?>">
        </div>
        <div class="col-6 mb-2">
          <label for="close_time" class="form-label">*休息時間</label>
          <input type="time" class="form-control" name="close_time" value="<?php echo $close_time; ?>">
        </div>

        <button class="col-1 btn btn-primary" type="submit">更新</button>
      </form>

    </div>

  </div>

  <?php include("../js-mahjong.php") ?>

</body>

</html>