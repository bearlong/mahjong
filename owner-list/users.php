<?php
require_once("../db_connect_mahjong.php");
session_start();


$sqlAll = "SELECT * FROM owner WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allUserCount = $resultAll->num_rows;


if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT * FROM owner WHERE (account LIKE '%$search%' OR company_name LIKE '%$search%' OR company_address LIKE '%$search%') AND valid = 1 ";
  $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
  $page = $_GET["page"];
  $perPage = 15;
  $firstItem = ($page - 1) * $perPage;
  $pageCount = ceil($allUserCount / $perPage);

  $order = $_GET["order"];
  // if ($order == 1) { // id ASC
  //   $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id ASC LIMIT $firstItem,$perPage";
  // }
  switch ($order) {
    case 1: // id ASC
      // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id ASC LIMIT $firstItem,$perPage";
      $orderClause = "ORDER BY id ASC";
      break;
    case 2: // id DESC
      // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id DESC LIMIT $firstItem,$perPage";
      $orderClause = "ORDER BY id DESC";
      break;
    case 3: // name ASC
      // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY name DESC LIMIT $firstItem,$perPage";
      $orderClause = "ORDER BY company_name ASC";
      break;
    case 4: // name DESC
      $orderClause = "ORDER BY company_name DESC";
      break;
  }

  $sql = "SELECT * FROM owner WHERE valid=1 $orderClause LIMIT $firstItem,$perPage";

  $pageTitle = "企業會員列表, 第 $page 頁";
} else {
  $sql = "SELECT id, company_name ,email, phone FROM owner WHERE valid = 1";
  $pageTitle = "使用者列表";
  header("location:users.php?page=1&order=1");
}



$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$userCount = $result->num_rows;
if (isset($_GET["page"])) {
  $userCount = $allUserCount;
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>owner</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container main-content px-5">
    <h1 class="text-center fw-semibold pt-3"><?= $pageTitle ?></h1>
    <div class="py-2 mb-3">
      <div class="d-flex justify-content-between">
        <div>
          <?php if (isset($_GET["search"])) : ?>
            <a href="users.php" class="btn btn-primary">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
          <?php endif ?>
        </div>

        <div class="d-flex gap-3">
          <form action="">
            <div class="input-group  position-relative z-0">
              <input type="text" class="form-control" placeholder="Search..." name="search">
              <button class="btn btn-primary" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </form>
          <a href="create-user.php" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i>
          </a>

        </div>
      </div>
    </div>

    <div class="pb-2 d-flex justify-content-between">
      <div>
        <?= "共 $userCount 人" ?>
      </div>
      <?php if (isset($_GET["page"])) : ?>
        <div>
          排序: <div class="btn-group  position-relative z-0">
            <a href="?page=<?= $page ?>&order=1" class="btn btn-primary 
            <?php if ($order == 1) echo "active" ?>">
              id <i class=" fa-solid fa-arrow-down-short-wide"></i>
            </a>
            <a href="?page=<?= $page ?>&order=2" class="btn btn-primary  
            <?php if ($order == 2) echo "active" ?>">
              id <i class="fa-solid fa-arrow-down-wide-short"></i>
            </a>
            <a href="?page=<?= $page ?>&order=3" class="btn btn-primary  
            <?php if ($order == 3) echo "active" ?>">
              company_name <i class="fa-solid fa-arrow-down-short-wide"></i>
            </a>
            <a href="?page=<?= $page ?>&order=4" class="btn btn-primary  
            <?php if ($order == 4) echo "active" ?>">
              company_name <i class="fa-solid fa-arrow-down-wide-short"></i>
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <?php if ($result->num_rows > 0) : ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th>負責人</th>
            <th>帳號</th>
            <th>公司名稱</th>
            <th>電話</th>
            <!-- <th>fax_phone</th> -->
            <th>Email</th>
            <th>公司地址</th>
            <th>統一編號</th>
            <th>created_at</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $owner) : ?>
            <tr>
              <td><?= $owner["id"] ?></td>
              <td><?= $owner["responsible_person"] ?></td>
              <td><?= $owner["account"] ?></td>

              <td><?= $owner["company_name"] ?></td>
              <td><?= $owner["company_phone"] ?></td>
              <td><?= $owner["company_email"] ?></td>
              <td><?= $owner["company_address"] ?></td>
              <td><?= $owner["tax_ID_number"] ?></td>
              <td><?= $owner["created_at"] ?></td>
              <td>
                <a href="user.php?id=<?= $owner["id"] ?>" class="btn btn-primary">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (isset($_GET["page"])) : ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
              <li class="page-item <?php if ($i == $page) echo "active" ?> ">
                <a class=" page-link" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>

    <?php else : ?>
      <?php echo "沒有使用者"; ?>
    <?php endif; ?>


  </div>
  <?php include("../js-mahjong.php") ?>
  <script>
    function filterCoupons(filter) {
      let url = new URL(window.location.href);
      url.searchParams.set("f", filter);
      url.searchParams.set("p", 1);
      url.searchParams.set("o", <?= $order ?>);
      url.searchParams.set("s", "<?= $search ?>");
      url.searchParams.set("s_d", "<?= $startDate ?>");
      url.searchParams.set("e_d", "<?= $endDate ?>");
      url.searchParams.set("mC", "<?= $minCash ?>");
      url.searchParams.set("MxC", "<?= $maxCash ?>");
      url.searchParams.set("mP", "<?= $minPercent ?>");
      url.searchParams.set("MxP", "<?= $maxPercent ?>");
      window.location.href = url.toString();
    }
  </script>
</body>

</html>