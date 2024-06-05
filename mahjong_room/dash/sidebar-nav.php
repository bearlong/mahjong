<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>業主後台管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../dash/css-mahjong.php") ?>
    <style>
        :root {
            --aside-width: 190px;
            --header-nav-height: 56px;
        }

        .navbar {
            padding-left: var(--aside-width);
        }

        .sidebar {
            width: var(--aside-width);
            height: 100vh;
            /* border-radius: 0 var(--header-nav-height) var(--header-nav-height) 0; */
            top: 0;
        }

        .sidebar ul {
            padding: 0;
            margin: 0;
        }

        .sidebar ul a {
            color: #999;
        }

        .arrow {
            position: absolute;
            right: 10px;
            display: none;
        }

        .sidebar ul a:hover,
        .sidebar ul a.active {
            background: linear-gradient(to right, #000 10%, goldenrod);
            color: white;
        }

        .list-unstyle {
            list-style: none;
        }

        .logo {
            width: calc(var(--aside-width) - 20px);
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
        }

        .main-content {
            margin: 0 0 0 var(--aside-width);
        }

        .hamburger {
            font-size: 24px;
            color: goldenrod;
        }

        #switch {
            display: none;
        }

        #switch:checked~.list-group {
            max-height: 260px;
        }

        .list-group {
            top: var(--header-nav-height);
            right: -5px;
            max-height: 0;
            overflow: hidden;
            transition: .5s;
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid position-fixed bg-dark bg-gradient z-1">
            <nav class="navbar navbar-expand-lg ">

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item d-flex align-items-center text-light">
                            <a class="nav-link link-light active" aria-current="page" href="sidebar-nav.php">後台管理</a> / <a class="nav-link link-secondary" href="#"><?php if (isset($_SESSION["group"])) echo $_SESSION["group"] ?></a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-start mx-3">
                    <label for="switch"><i class="hamburger fa-solid fa-bars"></i></label>
                    <input type="checkbox" id="switch">
                    <div class="list-group position-absolute z-1">
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-house me-2"></i>首頁</a>
                        <a href="./sidebar-nav.php" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-list-check me-2"></i>業主後台管理</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-bars-progress me-2"></i>數據分析</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-regular fa-comment me-2"></i>意見回饋</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-gear me-2"></i>設定</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-door-closed me-2"></i>Sign out</a>
                    </div>
                </div>
            </nav>
        </div>

    </header>
    <aside class="sidebar bg-black position-fixed z-2">
        <div class="logo p-3">
            <a href=""><img class="object-fit-cover" src="../img/dong.webp" alt="" /></a>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <ul class="list-unstyle">
                <li>
                    <a data-group="會員資料" href="sidebar-nav.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員資料") echo "active" ?>"><i class="fa-solid fa-users me-2"></i>會員資料<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員資料") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="棋牌室" href="../userRoomsOverview.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室") echo "active" ?>"><i class="fa-solid fa-file-lines me-2"></i>棋牌室<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="創建棋牌室" href="../createRoom.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "創建棋牌室") echo "active" ?>"><i class="fa-solid fa-store me-2"></i>創建棋牌室<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "創建棋牌室") echo "d-inline" ?>">></span></a>
                </li>
                <!-- <li>
                    <a data-group="線上課程管理" href="sidebar-nav.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "active" ?>"><i class="fa-solid fa-landmark me-2"></i>線上課程管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="租借管理" href="./rent/rent-product-list.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "active" ?>"><i class="fa-solid fa-retweet me-2"></i>租借管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="優惠券管理" href="./coupon/coupon-list.php?page=1&order=1" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "active" ?>"><i class="fa-solid fa-ticket me-2"></i>優惠券管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="棋牌室管理" href="./mahjong_room/roomsOverview.php" class="d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "active" ?>"><i class="fa-solid fa-chess-board me-2"></i>棋牌室管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "d-inline" ?>">></span></a>
                </li> -->
            </ul>
            <div class="d-flex justify-content-start mt-5">
                <a class="d-block mx-4 py-2 text-decoration-none btn btn-outline-light" href="">
                    <i class="fa-solid fa-door-closed me-2"></i>Sign out
                </a>
            </div>
        </div>
    </aside>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../dash/js-mahjong.php") ?>

    <script>
        const asideLink = document.querySelectorAll(".sidebar ul a");
        const arrow = document.querySelectorAll(".arrow");

        for (let i = 0; i < asideLink.length; i++) {
            asideLink[i].addEventListener("click", function() {
                let group = this.dataset.group;

                $.ajax({
                        method: "POST", //or GET
                        url: "http://localhost/dash/navtry.php",
                        dataType: "json",
                        data: {
                            group: group,
                        },
                    })
                    .done(function(response) {
                        console.log(response);
                    }).fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
                arrow.classlist.toggle("active")
            });
        }
    </script>
</body>

</html>