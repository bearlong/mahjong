<?php
require_once("../db_connect_mahjong.php");
session_start();
$keepSessionKey = ["group"];
$keepSessionValue = [];

foreach ($keepSessionKey as $key) {
  if (isset($_SESSION[$key])) {
    $keepSessionValue[$key] = $_SESSION[$key];
  }
}
session_destroy();
session_start();

foreach ($keepSessionValue as $key => $value) {
  $_SESSION[$key] = $value;
}

$pageTitle = "優惠卷列表";
$perPage = 15;

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$order = isset($_GET["order"]) ? (int)$_GET["order"] : 1;
$filter = isset($_GET["filter"]) ? $_GET["filter"] : 'all';
$search = isset($_GET["search"]) ? $_GET["search"] : '';
$startDate = isset($_GET["start_date"]) ? $_GET["start_date"] : '';
$endDate = isset($_GET["end_date"]) ? $_GET["end_date"] : '';

$whereClause = "WHERE 1=1";

if ($filter == "active") {
  $whereClause .= " AND status = 'active'";
} else if ($filter == "inactive") {
  $whereClause .= " AND status = 'inactive'";
} else if ($filter == 'percent') {
  $whereClause .= " AND discount_type = 'percent'";
} else if ($filter == 'cash') {
  $whereClause .= " AND discount_type = 'cash'";
}

if (!empty($startDate) && !empty($endDate)) {
  $whereClause .= " AND valid_from >= '$startDate' AND valid_to <= '$endDate'";
} else if (!empty($search)) {
  $whereClause .= " AND (name LIKE '%$search%' OR discount_code LIKE '%$search%')";
}

$sqlCount = "SELECT COUNT(*) AS count FROM coupons $whereClause";
$countResult = $conn->query($sqlCount);
$countRow = $countResult->fetch_assoc();
$allCouponCount = $countRow["count"];
$firstItem = ($page - 1) * $perPage;

switch ($order) {
  case 1:
    $sqlOrder = "ORDER BY coupon_id DESC";
    break;
  case 2:
    $sqlOrder = "ORDER BY coupon_id ASC";
    break;
  case 3:
    $sqlOrder = "ORDER BY name DESC";
    break;
  case 4:
    $sqlOrder = "ORDER BY name ASC";
    break;
  case 5:
    $sqlOrder = "ORDER BY discount_code DESC";
    break;
  case 6:
    $sqlOrder = "ORDER BY discount_code ASC";
    break;
  case 7:
    $sqlOrder = "ORDER BY discount_type DESC";
    break;
  case 8:
    $sqlOrder = "ORDER BY discount_type ASC";
    break;
  case 9:
    $sqlOrder = "ORDER BY discount_value DESC";
    break;
  case 10:
    $sqlOrder = "ORDER BY discount_value ASC";
    break;
  case 11:
    $sqlOrder = "ORDER BY valid_from DESC";
    break;
  case 12:
    $sqlOrder = "ORDER BY valid_from ASC";
    break;
  case 13:
    $sqlOrder = "ORDER BY valid_to DESC";
    break;
  case 14:
    $sqlOrder = "ORDER BY valid_to ASC";
    break;
  case 15:
    $sqlOrder = "ORDER BY limit_value DESC";
    break;
  case 16:
    $sqlOrder = "ORDER BY limit_value ASC";
    break;
  case 17:
    $sqlOrder = "ORDER BY usage_limit DESC";
    break;
  case 18:
    $sqlOrder = "ORDER BY usage_limit ASC";
    break;
  case 19:
    $sqlOrder = "ORDER BY status DESC";
    break;
  case 20:
    $sqlOrder = "ORDER BY status ASC";
    break;
}

$searchResultTitle = "";

if (!empty($startDate) && !empty($endDate)) {
  $searchResultTitle = "$startDate 到 $endDate 的搜尋結果";
} else if (!empty($search)) {
  $searchResultTitle = "$search 的搜尋結果";
}

$filterTitle = "";

if ($filter == "active") {
  $filterTitle = "（可使用）";
} else if ($filter == "inactive") {
  $filterTitle = "（已停用）";
} else if ($filter == 'percent') {
  $filterTitle = "（百分比）";
} else if ($filter == 'cash') {
  $filterTitle = "（現金）";
} else if ($filter == 'all') {
  $filterTitle = "（所有）";
}

$pageCount = ceil($allCouponCount / $perPage);
$sql = "SELECT * FROM coupons $whereClause  $sqlOrder LIMIT $firstItem, $perPage";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

?>
<!doctype html>
<html lang="en">

<head>
  <title>coupon-list</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php"); ?>
  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-semibold" id="deleteModalLabel">確認停用優惠卷?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">取消</button>
          <a href="" type="button" class="btn btn-danger fw-semibold" id="confirm">確認</a>
        </div>
      </div>
    </div>
  </div>


  <div class="container main-content px-5">
    <div class="d-flex justify-content-center">
      <h1 class="py-2 fw-semibold"><?= $pageTitle ?></h1>
    </div>

    <div class="py-2 mb-3">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-3 border p-1 rounded">
            <form action="" method="get">
              <div class="d-flex justify-content-center gap-3 ">
                <div class="input-group">
                  <label for="start_date" class="input-group-text  fw-semibold">開始日期</label>
                  <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="input-group">
                  <label for="end_date" class="input-group-text fw-semibold">結束日期</label>
                  <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
                <input type="hidden" name="filter" value="<?= $filter ?>">
                <input type="hidden" name="search" value="<?= $search ?>">
                <input type="hidden" name="page" value="1">
                <input type="hidden" name="order" value="<?= $order ?>">
                <button type="submit" class="btn btn-primary" name="filter_btn"><i class="fa-solid fa-magnifying-glass"></i> </button>
              </div>
            </form>

            <div class="d-flex justify-content-between gap-3">
              <form action="" method="get">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="請輸入名稱或折扣碼" name="search" value="<?= isset($_POST['search']) ? $_POST['search'] : '' ?>">
                  <input type="hidden" name="filter" value="<?= $filter ?>">
                  <input type="hidden" name="start_date" value="<?= $startDate ?>">
                  <input type="hidden" name="end_date" value="<?= $endDate ?>">
                  <input type="hidden" name="page" value="1">
                  <input type="hidden" name="order" value="<?= $order ?>">
                  <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center gap-3  mb-3  border p-1 rounded">
            <div class="d-flex justify-content-center align-items-center gap-3">
              <?php if (isset($_GET["search"]) || isset($_GET["filter_btn"])) : ?>
                <a href="coupon-list.php?page=1&order=1" class="btn btn-primary justify-item-start fw-semibold">
                  <i class="fa-solid fa-arrow-left"></i> 返回
                </a>
              <?php endif ?>


              <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-primary fw-semibold" onclick="filterCoupons('all')">所有</button>
                <button class="btn btn-success fw-semibold" onclick="filterCoupons('active')"><i class="fa-regular fa-circle-check"></i> 可使用</button>
                <button class="btn btn-danger fw-semibold" onclick="filterCoupons('inactive')"><i class="fa-regular fa-circle-xmark"></i> 已停用</button>
                <button class="btn btn-info text-white fw-semibold" onclick="filterCoupons('cash')">$ 現金</button>
                <button class="btn btn-warning text-white fw-semibold" onclick="filterCoupons('percent')">% 百分比</button>
              </div>


            </div>

            <a href="add-coupon.php" class="btn btn-primary">
              <i class="fa-solid fa-plus"></i> <span class="fw-semibold">新增</span>
            </a>
          </div>

          <div class="text-secondary pb-1 fw-semibold">
            <?= "$filterTitle" . " " . "$searchResultTitle" . " " . "共 $allCouponCount 張優惠卷" ?>
          </div>

          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th># <a href="?page=<?= $page ?>&order=<?= ($order == 1) ? 2 : 1 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>優惠卷名稱 <a href="?page=<?= $page ?>&order=<?= ($order == 3) ? 4 : 3 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>折扣碼 <a href="?page=<?= $page ?>&order=<?= ($order == 5) ? 6 : 5 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>折扣類型 <a href="?page=<?= $page ?>&order=<?= ($order == 7) ? 8 : 7 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>折扣額 <a href="?page=<?= $page ?>&order=<?= ($order == 9) ? 10 : 9 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>有效起始日 <a href="?page=<?= $page ?>&order=<?= ($order == 11) ? 12 : 11 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>有效截止日 <a href="?page=<?= $page ?>&order=<?= ($order == 13) ? 14 : 13 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>使用最低消費金額 <a href="?page=<?= $page ?>&order=<?= ($order == 15) ? 16 : 15 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>可使用次數 <a href="?page=<?= $page ?>&order=<?= ($order == 17) ? 18 : 17 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>狀態 <a href="?page=<?= $page ?>&order=<?= ($order == 19) ? 20 : 19 ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" class="sort-icon text-black"><i class="fa-solid fa-sort"></i></a></th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $coupon) : ?>
                <tr>
                  <td><?php echo $coupon['coupon_id'] ?></td>
                  <td><?php echo $coupon['name'] ?></td>
                  <td><?php echo $coupon['discount_code'] ?></td>
                  <td>
                    <?php if ($coupon['discount_type'] == 'cash') : ?>
                      <span class="text-primary fw-semibold">現金</span>
                    <?php elseif ($coupon['discount_type'] == 'percent') : ?>
                      <span class="text-warning fw-semibold">百分比</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($coupon['discount_type'] == 'cash') : ?>
                      <span class="text-primary fw-semibold"><?= '$' . " " . $coupon['discount_value']; ?></span>
                    <?php elseif ($coupon['discount_type'] == 'percent') : ?>
                      <span class="text-warning fw-semibold"><?= $coupon['discount_value'] . " " . '%'; ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo $coupon['valid_from'] ?></td>
                  <td><?php echo $coupon['valid_to'] ?></td>
                  <td>
                    <span class="text-danger fw-semibold"><?php echo  '$' . $coupon['limit_value'] ?></span>
                  </td>
                  <td><?php echo $coupon['usage_limit'] ?></td>
                  <td><span class="fw-semibold <?php echo ($coupon['status'] == 'active') ? 'text-success' : 'text-danger'; ?>">
                      <?php echo ($coupon['status'] == 'active') ? '<i class="fa-regular fa-circle-check"></i> 可使用' : '<i class="fa-regular fa-circle-xmark"></i> 已停用'; ?>
                    </span></td>
                  <td>
                    <a href="coupon-detail.php?coupon_id=<?= $coupon['coupon_id'] ?>" class="btn btn-primary" title="優惠卷詳細資料">
                      <i class="fa-solid fa-square-poll-horizontal"></i> </a>
                    <a href="edit-coupon.php?coupon_id=<?= $coupon["coupon_id"] ?> " title="編輯優惠卷" class="btn btn-primary">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <button class="btn btn-danger btn-disable" title="停用優惠卷" data-id="<?= $coupon["coupon_id"] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash-can"></i></button>

                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>

          <div class="d-flex justify-content-center">
            <?php if (isset($_GET["page"])) : ?>
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo "active" ?>">
                      <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&filter=<?= $filter ?>&search=<?= $search ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"><?= $i ?></a>
                    </li>
                  <?php endfor; ?>
                </ul>
              </nav>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <script>
        // 使用api 抓 coupon _id 給 search 使用
        const btnDisable = document.querySelectorAll('.btn-disable');
        const confirm = document.querySelector('#confirm');

        for (let i = 0; i < btnDisable.length; i++) {
          btnDisable[i].addEventListener('click', function() {
            let couponId = btnDisable[i].dataset.id;
            confirm.href = "doDisableCoupon.php?coupon_id=" + couponId;
          });
        };

        // 防止日期選擇至起始日之前
        document.getElementById("start_date").addEventListener("change", function() {
          document.getElementById("end_date").min = this.value;
        });
        document.getElementById("end_date").addEventListener("change", function() {
          document.getElementById("start_date").max = this.value;
        });

        function filterCoupons(filter) {
          let url = new URL(window.location.href);
          url.searchParams.set("filter", filter);
          url.searchParams.set("page", 1); // 重置到第一頁
          url.searchParams.set("order", <?= $order ?>);
          url.searchParams.set("search", "<?= $search ?>");
          url.searchParams.set("start_date", "<?= $startDate ?>");
          url.searchParams.set("end_date", "<?= $endDate ?>");
          window.location.href = url.toString();
        }
      </script>
      <?php include("../js-mahjong.php") ?>
</body>

</html>