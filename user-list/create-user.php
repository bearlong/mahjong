<!doctype html>
<html lang="en">

<head>
  <title>create user</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("../css-mahjong.php") ?>

</head>

<body>
  <div class="container">
    <div class="py-2">
      <a class="btn btn-primary" href="users.php"><i class="fa-solid fa-arrow-left"></i> 回使用者列表
      </a>
    </div>
    <form action="doCreateUser.php" method="post">
      <div class="mb-2">
        <label for="" class="form-label">*姓名</label>
        <input type="text" class="form-control" name="username">
      </div>
      <form action="doCreateUser.php" method="post">
        <div class="mb-2">
          <label for="" class="form-label">*帳號</label>
          <input type="text" class="form-control" name="account">
        </div>
        <form action="doCreateUser.php" method="post">
          <div class="mb-2">
            <label for="" class="form-label">*密碼</label>
            <input type="text" class="form-control" name="password">
          </div>
          <form action="doCreateUser.php" method="post">
            <div class="mb-2">
              <label for="" class="form-label">*地址</label>
              <input type="text" class="form-control" name="Address">
            </div>
            <form action="doCreateUser.php" method="post">
              <div class="mb-2">
                <label for="" class="form-label">*生日</label>
                <input type="text" class="form-control" name="birth">
              </div>
              <form action="doCreateUser.php" method="post">
                <div class="mb-2">
                  <label for="" class="form-label">*性別</label>
                  <input type="text" class="form-control" name="gender">
                </div>

                <div class="mb-2">
                  <label for="" class="form-label">*email</label>
                  <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-2">
                  <label for="" class="form-label">*電話</label>
                  <input type="tel" class="form-control" name="phone">
                </div>

                <button class="btn btn-primary" type="submit">送出</button>
              </form>
  </div>
  <?php include("../js-mahjong.php") ?>
</body>

</html>