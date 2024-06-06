<?php
require_once("../db_connect_mahjong.php");

$sqlAll = "SELECT * FROM users WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allUserCount = $resultAll->num_rows;

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT id, username ,email, phone FROM users WHERE account LIKE '%$search%' AND valid = 1 ";
    $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 15;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allUserCount / $perPage);

    $order = $_GET["order"];
    $orderType = isset($_GET["type"]) ? $_GET["type"] : 'asc';
    $orderClause = "";

    switch ($order) {
        case 1: // id
            $orderClause = "ORDER BY id $orderType";
            break;
        case 2: // name
            $orderClause = "ORDER BY username $orderType";
            break;
        case 3: // address
            $orderClause = "ORDER BY address $orderType";
            break;
    }

    $sql = "SELECT * FROM users WHERE valid=1 $orderClause LIMIT $firstItem,$perPage";
    $pageTitle = "會員列表 第 $page 頁";
} else {
    $sql = "SELECT id, username ,email, phone FROM users WHERE valid = 1";
    $pageTitle = "會員列表";
    header("location:users.php?page=1&order=1&type=asc");
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$userCount = $result->num_rows;
if (isset($_GET["page"])) {
    $userCount = $allUserCount;
}

// 處理刪除請求
if (isset($_POST['delete'])) {
    $idsToDelete = $_POST['ids'];
    if (!empty($idsToDelete)) {
        $idsToDelete = implode(',', $idsToDelete);
        $deleteSql = "UPDATE users SET valid = 0 WHERE id IN ($idsToDelete)";
        $conn->query($deleteSql);
        header("location: users.php?page=1&order=1&type=asc");
    }
}

// 處理狀態更新請求
if (isset($_POST['update_status'])) {
    $updates = $_POST['status'];
    foreach ($updates as $id => $status) {
        $status = ($status === 'true') ? 1 : 0;
        $updateSql = "UPDATE users SET status = $status WHERE id = $id";
        $conn->query($updateSql);
    }
    header("location: users.php?page=1&order=1&type=asc");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member List</title>
    <?php include("../css-mahjong.php") ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }



        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header select,
        .header button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .header button {
            cursor: pointer;
        }

        .table-container {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            /* width: 100%; */
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #6c63ff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }


        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .footer button {
            margin: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .footer .save {
            background-color: #6c63ff;
            color: white;
        }

        .footer .cancel {
            background-color: #ff4d4d;
            color: white;
            margin-left: 10px;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            margin: 20px;
        }

        .pagination a {
            color: #6c63ff;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #6c63ff;
            color: white;
            border: 1px solid #6c63ff;
        }

        .color {
            --bs-btn-bg: #6c63ff;
            --bs-btn-border-color: #6c63ff;
            --bs-btn-hover-bg: #9e4aed;
            --bs-btn-hover-border-color: #9e4aed;
            --bs-btn-active-bg: #9e4aed;
            --bs-btn-active-border-color: #9e4aed;
        }
    </style>
</head>

<body>
    <?php include("../nav.php") ?>

    <div class="container main-content px-5">
        <div class="header py-3">
            <div>
                <label for="control-level">Control Level</label>
                <select id="control-level">
                    <option value="client-list">Client List</option>
                </select>
            </div>
            <div>
                <form action="" method="get" class="d-inline">
                    <div class="input-group position-relative z-0">
                        <input type="text" class="form-control" placeholder="Search..." name="search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
                <a href="create-user.php"><button type="button" class="btn btn-dark my-2">Add New Registration</button></a>
            </div>
        </div>
        <div class="table-container mb-5">
            <form method="post" action="">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>
                                id
                                <a href="?page=<?= $page ?>&order=1&type=<?= $order == 1 && $orderType == 'asc' ? 'desc' : 'asc' ?>">
                                    <i class="fa-solid fa-arrow-<?= $order == 1 && $orderType == 'asc' ? 'down' : 'up' ?>"></i>
                                </a>
                            </th>
                            <th>
                                username
                                <a href="?page=<?= $page ?>&order=2&type=<?= $order == 2 && $orderType == 'asc' ? 'desc' : 'asc' ?>">
                                    <i class="fa-solid fa-arrow-<?= $order == 2 && $orderType == 'asc' ? 'down' : 'up' ?>"></i>
                                </a>
                            </th>
                            <th>account</th>
                            <th>
                                Address
                                <a href="?page=<?= $page ?>&order=3&type=<?= $order == 3 && $orderType == 'asc' ? 'desc' : 'asc' ?>">
                                    <i class="fa-solid fa-arrow-<?= $order == 3 && $orderType == 'asc' ? 'down' : 'up' ?>"></i>
                                </a>
                            </th>
                            <th>birth</th>
                            <th>gender</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>created_at</th>
                            <th>Status</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $user) : ?>
                            <tr>
                                <td><input type="checkbox" class="checkBox" name="ids[]" value="<?= $user["id"] ?>"></td>
                                <td><?= $user["id"] ?></td>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["account"] ?></td>
                                <td><?= $user["Address"] ?></td>
                                <td><?= $user["birth"] ?></td>
                                <td><?= $user["gender"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td><?= $user["created_at"] ?></td>
                                <td>
                                    <!-- <span><?= $user["status"] ? 'Active' : 'Inactive' ?></span>
                                    <input type="hidden" name="status[<?= $user["id"] ?>]" value="<?= $user["status"] ? 'true' : 'false' ?>"> -->
                                </td>
                                <td>
                                    <a href="user.php?id=<?= $user["id"] ?>" class="btn color btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="footer">
                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirmDelete()">刪除選中項目</button>
                    <div class="pagination">
                        <?php if ($pageCount > 1) : ?>
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <a href="?page=<?= $i ?>&order=<?= $order ?>&type=<?= $orderType ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.querySelectorAll('.checkBox');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        function confirmDelete() {
            return confirm('你確定要刪除選中的項目嗎？');
        }
    </script>
    <?php include("../js-mahjong.php") ?>
</body>

</html>