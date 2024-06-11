<?php
session_start();
unset($_SESSION["group"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>dashboard</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    :root {
      --aside-width: 280px;
      --header-height: 56px;
    }

    .logo-box {
      width: var(--aside-width);
    }

    .aside-left {
      padding-top: var(--header-height);
      width: var(--aside-width);
      top: 0;
      overflow: auto;
    }

    .statistical,
    .print {
      cursor: pointer;
    }

    .main {
      margin: var(--header-height) 0 0 var(--aside-width);
    }

    .switch {
      width: 48px;
      height: 30px;
      right: 30px;
      bottom: 30px;
      cursor: pointer;

      .switch-button-day {
        width: 16px;
        height: 16px;
        border: 5px solid #000;
        background: #000;
        transform: translateX(4px);
        transition: 0.4s;
      }

      .switch-button-night {
        width: 15px;
        height: 15px;
        border: 5px solid #aaa;
        background: #aaa;
        transform: translateX(26px);
        transition: 0.4s;
      }
    }

    .switchText {
      right: 80px;
      bottom: 33px;
    }

    @media print {
      .no-print {
        display: none;
      }

      .main {
        margin: 0;
      }
    }
  </style>
</head>

<body>
  <header class="no-print main-header bg-dark d-flex fixed-top shadow justify-content-between align-items-center">
    <a href="" class="no-print bg-black text-white text-decoration-none p-3 logo-box">
      只欠東風<span class="fs-6"><i class="fa-regular fa-registered"></i></span>
    </a>
    <div class="no-print px-2 fs-6 switchText position-fixed" id="switchText">
      Light
    </div>
    <div class="bd-black rounded-pill border border-dark switch d-flex align-items-center position-fixed no-print" id="switchBox" curse>
      <div class="no-print border-5 rounded-circle switch-button-day" id="switchButton"></div>
    </div>
    <div class="no-print text-white me-3">
      <a href="../manber/doLogout.php" class="btn btn-dark">
        <i class="bi bi-door-closed me-2"></i>Sign out
      </a>
    </div>
  </header>
  <aside class="no-print aside-left bg-light position-fixed border-end vh-100" id="asidLeft">
    <ul class="list-unstyled">
      <li>
        <a href="../sidebar-nav.php" class="d-block px-3 py-2 text-decoration-none">
          <i class="bi bi-house-fill me-2"></i>後台管理
        </a>
      </li>
      <li>
        <a class="d-block px-3 py-2 text-decoration-none statistical">
          <i class="bi bi-people me-2"></i>用戶統計
        </a>
      </li>
      <li>
        <a class="d-block px-3 py-2 text-decoration-none statistical">
          <i class="bi bi-file-earmark me-2"></i>歷史訂單
        </a>
      </li>
      <li>
        <a class="d-block px-3 py-2 text-decoration-none" href="">
          <i class="bi bi-cart me-2"></i>銷售數據
        </a>
      </li>
    </ul>
    <div class="aside-title d-flex justify-content-between align-items-center px-3">
      <a class="text-decoration-none text-secondary m-0 print" onclick="window.print()">SAVED REPORTS <i class="bi bi-plus-circle"></i></a>
    </div>
    <hr />
    <ul class="list-unstyled">
      <li>
        <a class="d-block px-3 py-2 text-decoration-none" href="">
          <i class="bi bi-gear-wide-connected me-2"></i>Settings
        </a>
      </li>
      <li>
        <a class="d-block px-3 py-2 text-decoration-none" href="../manber/doLogout.php">
          <i class="bi bi-door-closed me-2"></i>Sign out
        </a>
      </li>
    </ul>
  </aside>
  <main class="main p-3" id="mainContent">
    <div class="pages d-none">
      <?php include("memberStatistical.php"); ?>
    </div>
    <div class="pages d-none">
      <?php include("rentStatistical.php"); ?>
    </div>
  </main>

  <script>
    const switchBox = document.querySelector("#switchBox");
    const switchButton = document.querySelector("#switchButton");
    const asidLeft = document.querySelector("#asidLeft");
    const mainContent = document.querySelector("#mainContent");
    const body = document.querySelector("body");
    const table = document.querySelector("#table");
    const switchText = document.querySelector("#switchText");
    const btnSm = document.querySelector(".btn-sm");
    const statistical = document.querySelectorAll(".statistical");
    const pages = document.querySelectorAll(".pages");

    switchBox.addEventListener("click", function() {
      switchButton.classList.toggle("switch-button-day");
      switchButton.classList.toggle("switch-button-night");
      switchBox.classList.toggle("border-dark");
      switchBox.classList.toggle("border-secondary");
      mainContent.classList.toggle("bg-light");
      mainContent.classList.toggle("bg-dark");
      asidLeft.classList.toggle("bg-light");
      asidLeft.classList.toggle("bg-dark");
      body.classList.toggle("text-bg-dark");
      let content = switchText.textContent.trim(); // 確保沒有多餘的空格
      if (content === "Light") {
        switchText.textContent = "Dark";
      } else {
        switchText.textContent = "Light";
      }
    });

    for (let i = 0; i < statistical.length; i++) {
      statistical[i].addEventListener("click", function() {
        console.log("click");
        for (let j = 0; j < pages.length; j++) {
          pages[j].classList.add("d-none");
        }
        pages[i].classList.remove("d-none");
      });
    }
  </script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>