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
                    <a href="../sidebar-nav.php" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-list-check me-2"></i>後台管理</a>
                    <a href="../report/dashboard.php" class="list-group-item list-group-item-action list-group-item-dark"><i class="fa-solid fa-bars-progress me-2"></i>數據分析</a>
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
        <a href=""><img class="object-fit-cover" src="../images/logo.png" alt="" /></a>
    </div>
    <div class="d-flex flex-column justify-content-between">
        <ul class="list-unstyle">
            <li>
                <a data-group="會員管理" class="sub-sidebar-switch main-sidebar d-block px-4 py-2 mt-3  text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員管理") echo "active" ?>"><i class="fa-solid fa-users me-2"></i>會員管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "會員管理") echo "d-inline" ?>">></span></a>
                <ul class="text-center text-black bg-dark bg-gradient sub-label-ul">
                    <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="../user-list/users.php">一般會員</a></li>
                    <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="../owner-list/users.php">企業會員</a></li>
                </ul>
            </li>
            <li>
                <a data-group="訂單管理" class="sub-sidebar-switch main-sidebar d-block px-4 py-2 mt-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "訂單管理") echo "active" ?>"><i class="fa-solid fa-file-lines me-2"></i>訂單管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "訂單管理") echo "d-inline" ?>">></span></a>
                <ul class="text-center text-black bg-dark bg-gradient sub-label-ul">
                    <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="">一般訂單</a></li>
                    <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="">線上課程訂單</a></li>
                    <li class="border border-start-0 border-end-0 border-black"><a class="d-block sub-label text-decoration-none py-1" href="../rent/rent-record-list.php">租借訂單</a></li>
                </ul>
            </li>
            <li>
                <a data-group="商品管理" href="../sidebar-nav.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "商品管理") echo "active" ?>"><i class="fa-solid fa-store me-2"></i>商品管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "商品管理") echo "d-inline" ?>">></span></a>
            </li>
            <li>
                <a data-group="線上課程管理" href="../mjphp/course-list.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "active" ?>"><i class="fa-solid fa-landmark me-2"></i>線上課程管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "線上課程管理") echo "d-inline" ?>">></span></a>
            </li>
            <li>
                <a data-group="租借管理" href="../rent/rent-product-list.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "active" ?>"><i class="fa-solid fa-retweet me-2"></i>租借管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "租借管理") echo "d-inline" ?>">></span></a>
            </li>
            <li>
                <a data-group="優惠券管理" href="../coupon/coupon-list.php?page=1&order=1" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "active" ?>"><i class="fa-solid fa-ticket me-2"></i>優惠券管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "優惠券管理") echo "d-inline" ?>">></span></a>
            </li>
            <li>
                <a data-group="棋牌室管理" href="../mahjong_room/allRooms.php" class="main-sidebar d-block px-4 py-2 my-3 text-decoration-none <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "active" ?>"><i class="fa-solid fa-chess-board me-2"></i>棋牌室管理<span class="arrow <?php if (isset($_SESSION["group"]) && $_SESSION["group"] === "棋牌室管理") echo "d-inline" ?>">></span></a>
            </li>
        </ul>
        <div class="d-flex justify-content-start mt-5">
            <a class="d-block mx-4 py-2 text-decoration-none btn btn-outline-light" href="">
                <i class="fa-solid fa-door-closed me-2"></i>Sign out
            </a>
        </div>
    </div>
</aside>