<?php
require_once("../db_connect_mahjong.php");
session_start();

?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>業主後台</title>
  <?php include("../css-mahjong.php") ?>
  <style>
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      padding: 48px 0 0;
      box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar-sticky {
      position: relative;
      top: 0;
      height: calc(100vh - 48px);
      padding-top: .5rem;
      overflow-x: hidden;
      overflow-y: auto;
    }

    .nav-link:hover {
      color: #0056b3;
    }
  </style>
</head>

<body>
  <?php include("../nav.php") ?>

  <div class="container-fluid main-content px-5">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <span data-feather="home"></span>
                儀表板
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="roomInformation.php">
                <span data-feather="file"></span>
                註冊基本資料
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="updateBasicInformation.php">
                <span data-feather="file"></span>
                更新基本資料
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="updateTime.php">
                <span data-feather="clock"></span>
                更新營業時間
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="createTable.php">
                <span data-feather="grid"></span>
                桌位管理系統
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="roomsOverview.php">
                <span data-feather="list"></span>
                房間總覽
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">儀表板</h1>
        </div>

        <div class="container">
          <div class="row">
            <div class="col">
              <h2>歡迎來到儀表板</h2>
              <p>請從左側導航欄選擇一個選項以繼續。</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <?php include("../js-mahjong.php") ?>

</body>

</html>