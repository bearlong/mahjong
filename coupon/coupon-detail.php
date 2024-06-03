<?php
if (!isset($_GET["coupon_id"])) {
  $coupon_id = 4;
} else {
  $coupon_id = $_GET["coupon_id"];
}
session_start();


require_once("../db_connect_mahjong.php");

$sql = "SELECT * FROM coupons WHERE coupon_id  = $coupon_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
  $coupon = true;
  $title = $row["coupon_id"];
} else {
  $coupon = false;
  $title = "優惠卷不存在";
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
  <div class="container row justify-content-center main-content">
    <div class="col-12 px-3">
      <div class="py-3">
        <a class="btn btn-primary" href="coupon-list.php?page=1&order=1"><i class="fa-solid fa-arrow-left"></i> 回優惠卷列表
        </a>
      </div>

      <div class="row justify-content-center">
        <div class="col-8">

          <?php if ($result->num_rows > 0) : ?>
            <table class="table table-bordered">
              <tr>
                <th class="col-3">優惠卷編號</th>
                <td class="col-9"><?= $row["coupon_id"] ?></td>
              </tr>
              <tr>
                <th>優惠卷名稱</th>
                <td><?= $row["name"] ?></td>
              </tr>
              <tr>
                <th>優惠卷折扣碼</th>
                <td><?= $row["discount_code"] ?></td>
              </tr>
              <tr>
                <th>優惠卷折扣類型</th>
                <td><?= $row["discount_type"] ?></td>
              </tr>
              <tr>
                <th>優惠卷折扣值</th>
                <td><?= $row["discount_value"] ?></td>
              </tr>
              <tr>
                <th>優惠卷有效期</th>
                <td><?= $row["valid_from"] ?> ~ <?= $row["valid_to"] ?></td>
              </tr>
              <tr>
                <th>使用最低消費金額</th>
                <td><?= $row["limit_value"] ?></td>
              </tr>
              <tr>
                <th>可使用次數</th>
                <td><?= $row["usage_limit"] ?></td>
              </tr>
              <tr>
                <th>狀態</th>
                <td><?php echo ($row['status']) == 'active' ? '可使用' : '已停用'; ?></td>
              </tr>
            </table>
        </div>
      <?php else : ?>
        <h1>使用者不存在</h1>
      <?php endif; ?>
      </div>
    </div>
  </div>



  <!-- Bootstrap JavaScript Libraries -->
  <?php include("../js-mahjong.php"); ?>

</body>

</html>