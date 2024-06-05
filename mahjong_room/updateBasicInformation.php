<?php
require_once("../db_connect_mahjong.php");
session_start();
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id === 0) {
  die("無效的房間 ID");
}

$sql = "SELECT name, tele, address FROM mahjong_room WHERE room_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = $row['name'] ?? '';
$tele = $row['tele'] ?? '';
$address = $row['address'] ?? '';

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>updateBasicInformation</title>
  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php") ?>

  <div class="container main-content px-5">
    <form action="doUpdateBasicInfomation.php" method="post">
      <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
      <div class="mb-3">
        <label for="name" class="form-label">*門店名稱</label>
        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
      </div>
      <div class="mb-3">
        <label for="tele" class="form-label">*電話</label>
        <input type="tel" class="form-control" name="tele" value="<?php echo htmlspecialchars($tele); ?>" required>
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">*門店地址</label>
        <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
      </div>
      <button class="btn btn-primary" type="submit">更新</button>
    </form>
  </div>
  <?php include("../js-mahjong.php") ?>

</body>

</html>