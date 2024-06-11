<?php
session_start();

require_once("../db_connect_mahjong.php");

if (isset($_SESSION["users"])) {
    header("Location:dashboard.php");
    exit;
}


?>



<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>只欠東風</title>
    <?php include("../css-mahjong.php") ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url("../images/good.jpg");
            background-size: cover;
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            opacity: .9;
        }


        .form {
            display: none;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .form.show {
            opacity: 1;
            display: block;
        }

        .form.hide {
            opacity: 0;
            display: block;
        }

        .changeBtn {
            cursor: pointer;
        }

        .form-fade {

            animation: fade 1s linear 0s;
        }

        @keyframes fade {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modalTriggerButton">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-semibold" id="exampleModalLabel">歡迎光臨</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    註冊成功!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if (!isset($_SESSION["register"])) : ?>
            <form action="doLogin.php" id="loginForm" class="form show" method="post">
                <h1 class="h3 fw-semibold">登入</h1>
                <div class="form-floating mb-3">
                    <input type="text" name="account" class="form-control" id="floatingAccount" placeholder="name@example.com">
                    <label for="floatingAccount">帳號</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">密碼</label>
                </div>

                <div class="pb-2">

                    <label class="form-check-label" for="flexCheckChecked">
                        Remember me
                    </label>
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                </div>

                <?php if (isset($_SESSION["errorMsg"])) : ?>
                    <div class="text-danger py-2"><?= $_SESSION["errorMsg"]   ?></div>

                    <?php unset($_SESSION["errorMsg"]) ?>
                <?php endif; ?>
                <div class="pb-2 text-secondary">還沒有加入會員嗎? <a class="changeBtn btn btn-light" id="registerBtn">立即註冊</a></div>
                <button class="btn btn-dark" type="submit">登入</button>
            </form>
            <form id="registerForm" class="form" method="post" action="register.php">
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" id="floatingUsername" placeholder="Password">
                    <label for="floatingUsername">用戶名</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="account" class="form-control" id="floatingAccountRegister" placeholder="name@example.com">
                    <label for="floatingAccountRegister">請輸入4~20字元的帳號</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPasswordRegister" placeholder="Password">
                    <label for="floatingPasswordRegister">密碼</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="passwordCheck" class="form-control" id="floatingPasswordCheck" placeholder="Password">
                    <label for="floatingPasswordCheck">再輸入一次密碼</label>
                </div>
                <div class="changeBtn pb-2" id="loginBtn">已經是會員了嗎?</div>
                <button class="btn btn-dark" type="submit">下一步</button>
            </form>
        <?php else : ?>
            <form action="register.php" id="detailForm" class="form-fade" method="post">
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Password">
                    <label for="floatingEmail">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="phone" name="phone" class="form-control" id="floatingPhone" placeholder="Password">
                    <label for="floatingPhone">電話</label>
                </div>
                <div class="pb-2">
                    <select class="form-select" name="city" aria-label="Default select example">
                        <option selected>選擇城市</option>
                        <option value="taipei">台北</option>
                        <option value="Taichung">台中</option>
                        <option value="Kaohsiung">高雄</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <input type="address" name="address" class="form-control" id="floatingAddress" placeholder="Password">
                    <label for="floatingAddress">地址</label>
                </div>
                <div class="pb-2 d-flex justify-content-around">
                    <div class="form-check">
                        <input class="form-check-input" value="male" type="radio" name="gender" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            男
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="female" type="radio" name="gender" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            女
                        </label>
                    </div>
                </div>
                <div class="pb-2">
                    <label>
                        Enter your birthday: </label>
                    <input class="form-control" type="date" name="birth" required pattern="\d{4}-\d{2}-\d{2}" />
                    <span class="validity"></span>
                </div>
                <?php if (isset($_SESSION["errorMsg"])) : ?>
                    <div class="text-danger py-2"><?= $_SESSION["errorMsg"]   ?></div>
                    <?php unset($_SESSION["errorMsg"]) ?>
                <?php endif; ?>
                <button class="btn btn-dark" type="submit">註冊</button>
            </form>
        <?php endif; ?>

    </div>
    <?php include("../js-mahjong.php"); ?>
    <script>
        const loginBtn = document.getElementById('loginBtn');
        const registerBtn = document.getElementById('registerBtn');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function showForm(formToShow, formToHide) {
            formToHide.classList.add('hide');
            formToHide.classList.remove('show');

            setTimeout(() => {
                formToHide.style.display = 'none';
                formToShow.style.display = 'block';
                setTimeout(() => {
                    formToShow.classList.add('show');
                    formToShow.classList.remove('hide');
                }, 100); // 短暫延遲以確保CSS過渡應用
            }, 100); // 過渡時間1秒後設置display:none
        }

        loginBtn.addEventListener('click', () => {
            showForm(loginForm, registerForm);
        });

        registerBtn.addEventListener('click', () => {
            showForm(registerForm, loginForm);
        });

        <?php if (isset($_SESSION["register_success"])) : ?>
            var modalTriggerButton = document.getElementById('modalTriggerButton');
            if (modalTriggerButton) {
                modalTriggerButton.click();
            }
            <?php unset($_SESSION["register_success"]);
            ?>
        <?php endif; ?>
    </script>

</body>

</html>