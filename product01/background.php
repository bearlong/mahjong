<?php
require_once("../db_connect_mahjong.php");
session_start();

// 軟刪除產品
if (isset($_GET['action']) && $_GET['action'] == 'soft_delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE product SET deleted_at=NOW() WHERE id=$id";
    $result = $conn->query($sql);
}

// 復原產品
if (isset($_GET['action']) && $_GET['action'] == 'restore' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE product SET deleted_at=NULL WHERE id=$id";
    $result = $conn->query($sql);
}

// 設定每頁顯示的產品數量
$products_per_page = 20;

// 獲取當前頁碼，預設為第1頁
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page <= 0) {
    $current_page = 1;
}

// 計算要跳過的產品數量
$offset = ($current_page - 1) * $products_per_page;

// 搜尋產品名稱
$search = "";
$where_clause = "p.deleted_at IS NULL"; // 預設條件
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $where_clause .= " AND p.name LIKE '%" . $conn->real_escape_string($search) . "%'";
}

if (isset($_GET['show_deleted']) && $_GET['show_deleted'] == 'true') {
    $where_clause = "p.deleted_at IS NOT NULL";
    if ($search) {
        $where_clause .= " AND p.name LIKE '%" . $conn->real_escape_string($search) . "%'";
    }
}

$sql = "SELECT p.*, b.name AS brand_name FROM product p LEFT JOIN brand b ON p.brand_id = b.id WHERE $where_clause LIMIT $offset, $products_per_page";
$result = $conn->query($sql);
if (!$result) {
    die("SQL 錯誤：" . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <title>產品後台管理</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css-mahjong.php") ?>
</head>

<body>
    <?php include("../nav.php") ?>

    <div class="container main-content px-5">
        <h1 class="mt-3 mb-3">產品後台管理</h1>

        <!-- 搜尋表單 -->
        <form action="" method="GET" class="mb-3">
            <div class="input-group position-relative z-0">
                <input type="text" class="form-control" placeholder="搜尋產品名稱" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-secondary" type="submit">搜尋</button>
            </div>
        </form>

        <div class="d-flex justify-content-between mb-3">
            <h3>產品列表</h3>
            <a href="?page=1&show_deleted=true" class="btn btn-warning">已下架</a>
            <a href="create-product.php" class="btn btn-success">新增</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">名稱</th>
                    <th scope="col">數量</th>
                    <th scope="col">價格</th>
                    <th scope="col">品牌</th>
                    <th scope="col">上架時間</th>
                    <th scope="col">下架時間</th>
                    <th scope="col">圖片</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_name = $row["name"];
                        if ($row["deleted_at"] !== NULL) {
                            $product_name .= "（已下架）";
                        }
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . htmlspecialchars($product_name) . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["brand_name"]) . "</td>"; // 顯示品牌名稱
                        echo "<td>" . $row["create_at"] . "</td>";
                        echo "<td>" . $row["off_time"] . "</td>";
                        echo "<td><img src='./uploads/" . htmlspecialchars($row["img"]) . "' alt='產品圖片' style='width: 100px; height: auto;'></td>";
                        echo "<td>";
                        echo "<div class='btn-toolbar' role='toolbar'>";
                        echo "<div class='btn-group' role='group'>";
                        echo "<a href='edit_product.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>編輯</a>";
                        echo "<a href='?action=soft_delete&id=" . $row["id"] . "' class='btn btn-danger btn-sm'>下架</a>";
                        echo "<a href='?action=restore&id=" . $row["id"] . "' class='btn btn-success btn-sm'>復原</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>暫無產品</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- 分頁 -->
        <nav>
            <ul class="pagination">
                <?php
                $sql_total = "SELECT COUNT(*) FROM product p LEFT JOIN brand b ON p.brand_id = b.id WHERE $where_clause";
                $result_total = $conn->query($sql_total);
                $total_products = $result_total->fetch_row()[0];
                $total_pages = ceil($total_products / $products_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='?page=$i";
                    if (isset($_GET['show_deleted']) && $_GET['show_deleted'] == 'true') {
                        echo "&show_deleted=true";
                    }
                    if ($search) {
                        echo "&search=" . urlencode($search);
                    }
                    echo "'>" . $i . "</a></li>";
                }
                ?>
            </ul>
        </nav>

        <!-- 回首頁按鈕 -->
        <?php
        if (isset($_GET['show_deleted']) && $_GET['show_deleted'] == 'true') {
            echo "<a href='background.php' class='btn btn-secondary mt-3'>回首頁</a>";
        }
        ?>
    </div>
    <?php include("../js-mahjong.php") ?>

</body>

</html>