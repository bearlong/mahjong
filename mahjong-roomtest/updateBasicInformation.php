<?php
require_once("../db_connect.php");
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id == 0) {
  die("無效的房間 ID");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>updateBasicInformation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    <form action="doUpdateBasicInfomation.php" method="post">
      <div class="row justify-content-center align-items-center g-2">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
        <div class="col-6 mb-2">
          <label for="tele" class="form-label">*電話</label>
          <input type="tel" class="form-control" name="tele">
        </div>
        <div class="col-6 mb-2">
          <label for="address" class="form-label">*門店地址</label>
          <input type="text" class="form-control" name="address">
        </div>
        <button class="col-1 btn btn-primary" type="submit">更新</button>
      </div>
    </form>
  </div>
</body>

</html>