<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("./css-mahjong.php") ?>
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

        .sidebar ul .sub-label:hover {
            background: #999;
            transition: .3s;
        }

        .main-sidebar {
            cursor: pointer;
        }

        .sub-label-ul {
            max-height: 0px;
            overflow: hidden;
            transition: .5s;
        }

        .sub-label-ul-active {
            max-height: 100px;
            overflow: hidden;
            transition: .5s;
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
            cursor: pointer;
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

        .bg {
            height: 100vh;
        }

        .hidden {
            opacity: 0;
            transition: opacity 1s ease-in-out;
            margin: 0;
            min-height: calc(100vh - var(--header-nav-height));
        }

        .visible {
            opacity: 1;
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
                    <div class="list-group list-group-nav position-absolute z-1">
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-house me-2"></i>首頁</a>
                        <a href="./sidebar-nav.php" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-list-check me-2"></i>後台管理</a>
                        <a href="./report/dashboard.php" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-bars-progress me-2"></i>數據分析</a>
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
            <a href=""><img class="object-fit-cover" src="./images/logo.png" alt="" /></a>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <ul class="list-unstyle">
                <li>
                    <a data-group="會員管理" class="sub-sidebar-switch main-sidebar d-block px-4 py-2 mt-3  text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員管理") echo "active" ?>"><i class="fa-solid fa-users me-2"></i>會員管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員管理") echo "d-inline" ?>">></span></a>
                    <ul class="text-center text-black bg-dark bg-gradient sub-label-ul">
                        <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="./user-list/users.php?page=1&order=1">一般會員</a></li>
                        <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="./owner-list/users.php">企業會員</a></li>
                    </ul>
                </li>
                <li>
                    <a data-group="訂單管理" class="sub-sidebar-switch main-sidebar d-block px-4 py-2 mt-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "訂單管理") echo "active" ?>"><i class="fa-solid fa-file-lines me-2"></i>訂單管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "訂單管理") echo "d-inline" ?>">></span></a>
                    <ul class="text-center text-black bg-dark bg-gradient sub-label-ul">
                        <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="">一般訂單</a></li>
                        <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="">線上課程訂單</a></li>
                        <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="./rent/rent-record-list.php">租借訂單</a></li>
                    </ul>
                </li>
                <li>
                    <a data-group="商品管理" href="./product/product-list.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "商品管理") echo "active" ?>"><i class="fa-solid fa-store me-2"></i>商品管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "商品管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="線上課程管理" href="./mjphp/course-list.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "active" ?>"><i class="fa-solid fa-landmark me-2"></i>線上課程管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="租借管理" href="./rent/rent-product-list.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "active" ?>"><i class="fa-solid fa-retweet me-2"></i>租借管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="優惠券管理" href="./coupon/coupon-list.php?page=1&order=1" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "active" ?>"><i class="fa-solid fa-ticket me-2"></i>優惠券管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "d-inline" ?>">></span></a>
                </li>
                <li>
                    <a data-group="棋牌室管理" href="./mahjong_room/allRooms.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "active" ?>"><i class="fa-solid fa-chess-board me-2"></i>棋牌室管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "d-inline" ?>">></span></a>
                </li>
            </ul>
            <div class="d-flex justify-content-start mt-5">
                <a class="d-block mx-4 py-2 text-decoration-none btn btn-outline-light" href="">
                    <i class="fa-solid fa-door-closed me-2"></i>Sign out
                </a>
            </div>
        </div>
    </aside>
    <div class=" main-content bg-black text-center">
        <img id="delayedElement" class="object-fit-cover hidden" src="./images/6af7416b99844a6d7c2f34c7439e46e8.jpg" alt="">
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        const asideLink = document.querySelectorAll(".sidebar ul .main-sidebar");
        const arrow = document.querySelectorAll(".arrow");
        const subSidebarSwitch = document.querySelectorAll(".sub-sidebar-switch");
        const subLabelUl = document.querySelectorAll(".sub-label-ul");


        for (let i = 0; i < asideLink.length; i++) {
            asideLink[i].addEventListener("click", function() {
                let group = this.dataset.group;

                $.ajax({
                        method: "POST", //or GET
                        url: "http://localhost/mahjong/navApi.php",
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
                arrow[i].classList.toggle("active");
            });
        }

        for (let i = 0; i < subSidebarSwitch.length; i++) {
            subSidebarSwitch[i].addEventListener("click", function() {
                for (let j = 0; j < asideLink.length; j++) {
                    arrow[j].classList.remove("d-inline");
                    asideLink[j].classList.remove("active");
                }
                console.log("click");
                arrow[i].classList.add("d-inline");
                subSidebarSwitch[i].classList.add("active");
                subLabelUl[i].classList.toggle("sub-label-ul-active");
            });

        }

        document.addEventListener("DOMContentLoaded", function() {
            // 設置延遲時間（毫秒）
            const delay = 500; // 2秒

            // 取得要延遲顯示的元素
            const element = document.getElementById("delayedElement");

            // 設置延遲顯示
            setTimeout(() => {
                element.classList.add("visible");
            }, delay);
        });
    </script>
</body>

</html>