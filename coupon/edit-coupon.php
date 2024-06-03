<?php
if (!isset($_GET["coupon_id"])) {
  $coupon_id = 1;
} else {
  $coupon_id = $_GET["coupon_id"];
}

require_once("../db_connect_mahjong.php");
session_start();

$sql = "SELECT * FROM coupons WHERE coupon_id  = $coupon_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
  $coupon = true;
  $title = $row["coupon_id"];
} else {
  $coupon = false;
  $title = "優惠卷不存在";
}

?>

<!doctype html>
<html lang="en">

<head>
  <title><?= $title ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <?php include("../css-mahjong.php") ?>
</head>

<body>

  <?php include("../nav.php") ?>
  <div class="container row justify-content-center main-content">
    <div class="col-12 px-3">
      <div class="py-3">
        <a class="btn btn-primary fw-semibold" href="coupon-list.php?page=1&order=1"><i class="fa-solid fa-arrow-left"></i> 回優惠卷列表
        </a>
      </div>


      <div class="row justify-content-center align-items-center">
        <div class="col-8">
          <?php if ($result->num_rows > 0) : ?>
            <form action="doEditCoupon.php" method="post">
              <table class="table table-bordered">
                <tr>
                  <input type="hidden" name="coupon_id" value="<?= $row["coupon_id"] ?>">
                  <th>優惠卷編號</th>
                  <td class="fw-semibold"><?= $row["coupon_id"] ?></td>
                </tr>
                <tr>
                  <th class="py-3">優惠卷名稱</th>
                  <td><input type="text" class="form-control <?php echo isset($_SESSION["name_class"]) ? $_SESSION["name_class"] : ''; ?>" id="name" name="name" value="<?= $row["name"] ?>">
                    <?php if (isset($_SESSION["name_error"])) : ?>
                      <div class="text-danger text-error pt-2">
                        <?php echo $_SESSION["name_error"]; ?>
                      </div>
                      <?php unset($_SESSION["name_error"]);
                      unset($_SESSION["name_class"]); ?>
                    <?php endif; ?>
                  </td>

                </tr>
                <tr>
                  <th class="py-3">優惠卷折扣碼</th>
                  <td>
                    <div class="input-group">
                      <input type="text" class="form-control <?php echo isset($_SESSION["discountCode_class"]) ? $_SESSION["discountCode_class"] : ''; ?>" name="discountCode" value="<?= $row["discount_code"] ?>" id="discountCode">
                      <button type="button" class="btn btn-primary fw-semibold" id="randomCode">生成隨機代碼</button>
                    </div>
                    <?php if (isset($_SESSION["discountCode_error"])) : ?>
                      <div class="text-danger text-error pt-2">
                        <?php echo $_SESSION["discountCode_error"]; ?>
                      </div>
                      <?php unset($_SESSION["discountCode_error"]);
                      unset($_SESSION["discountCode_class"]); ?>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th class="py-2">優惠卷折扣類型</th>
                  <td>
                    <div class=" row">
                      <div class="col-6">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="discountType" id="cashDiscount" value="cash" <?php if ($row["discount_type"] == 'cash') echo 'checked'; ?>>
                          <label class="form-check-label" for="cashDiscount">
                            <span class="fw-semibold <?php echo isset($_SESSION["discountType_text_color"]) ? $_SESSION["discountType_text_color"] : ''; ?>">金額折扣</span>
                          </label>
                          </label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="percentDiscount" name="discountType" value="percent" <?php if ($row["discount_type"] == 'percent') echo 'checked'; ?>>
                          <label class="form-check-label" for="percentDiscount">
                            <span class="fw-semibold <?php echo isset($_SESSION["discountType_text_color"]) ? $_SESSION["discountType_text_color"] : ''; ?>">百分比折扣</span>
                          </label>
                        </div>
                      </div>
                  </td>
                </tr>
                <tr>
                  <th class="col-3 py-3">優惠卷折扣值</th>
                  <td class="col-9">
                    <div id="cashDiscountValueDiv" <?php if ($row["discount_type"] !== 'cash') echo 'style="display: none;"'; ?>>
                      <div class="input-group">
                        <div class="input-group-text">$</div>
                        <input type="number" class="form-control <?php echo isset($_SESSION["cashDiscountValue_class"]) ? $_SESSION["cashDiscountValue_class"] : ''; ?>" id="cashDiscountValue" name="cashDiscountValue" value="<?= $row["discount_value"] ?>">
                      </div>
                      <?php if (isset($_SESSION["cashDiscountValue_error"])) : ?>
                        <div class="text-danger text-error pt-2">
                          <?php echo $_SESSION["cashDiscountValue_error"]; ?>
                        </div>
                        <?php unset($_SESSION["cashDiscountValue_error"]);
                        unset($_SESSION["cashDiscountValue_class"]); ?>
                      <?php endif; ?>
                    </div>


                    <div id="percentDiscountValueDiv" <?php if ($row["discount_type"] !== 'percent') echo 'style="display: none;"'; ?>>
                      <div class="input-group">
                        <input type="number" value="<?= $row["discount_value"]  ?>" min="0" max="100" class="form-control  <?php echo isset($_SESSION["percentDiscountValue_class"]) ? $_SESSION["percentDiscountValue_class"] : ''; ?>" name="percentDiscountValue">
                        <div class="input-group-text">%</div>
                      </div>
                      <?php if (isset($_SESSION["percentDiscountValue_error"])) : ?>
                        <div class="text-danger text-error pt-2">
                          <?php echo $_SESSION["percentDiscountValue_error"]; ?>
                        </div>
                        <?php unset($_SESSION["percentDiscountValue_error"]);
                        unset($_SESSION["percentDiscountValue_class"]); ?>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>

                <tr>
                  <th class="py-4">優惠卷有效期</th>
                  <td>
                    <div class=" row">
                      <div class="col-6">
                        <label for="validFrom" class="form-label fw-semibold">有效起始日：</label>
                        <input type="date" class="form-control       <?php echo isset($_SESSION["validFrom_class"]) ? $_SESSION["validFrom_class"] : ''; ?>" name="validFrom" id="validFrom" value="<?= $row["valid_from"] ?>">
                        <?php if (isset($_SESSION["validFrom_error"])) : ?>
                          <div class="text-danger text-error pt-2">
                            <?php echo $_SESSION["validFrom_error"]; ?>
                          </div>
                          <?php unset($_SESSION["validFrom_error"]);
                          unset($_SESSION["validFrom_class"]); ?>
                        <?php endif; ?>
                      </div>
                      <div class="col-6">
                        <label for="validTo" class="form-label fw-semibold">有效截止日：</label>
                        <input type="date" class="form-control   <?php echo isset($_SESSION["validTo_class"]) ? $_SESSION["validTo_class"] : ''; ?>" name="validTo" id="validTo" value="<?= $row["valid_to"] ?>">
                        <?php if (isset($_SESSION["validTo_error"])) : ?>
                          <div class="text-danger text-error pt-2">
                            <?php echo $_SESSION["validTo_error"]; ?>
                          </div>
                          <?php unset($_SESSION["validTo_error"]);
                          unset($_SESSION["validTo_class"]);  ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th class="py-3">使用最低消費金額</th>
                  <td>
                    <div class="input-group">
                      <div class="input-group-text">$</div>
                      <input type="number" class="form-control <?php echo isset($_SESSION["limitValue_class"]) ? $_SESSION["limitValue_class"] : ''; ?>" name="limitValue" value="<?= $row["limit_value"] ?>">
                    </div>
                    <?php if (isset($_SESSION["limitValue_error"])) : ?>
                      <div class="text-danger text-error pt-2">
                        <?php echo $_SESSION["limitValue_error"]; ?>
                      </div>
                      <?php unset($_SESSION["limitValue_error"]);
                      unset($_SESSION["limitValue_class"]); ?>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th class="py-3">可使用次數</th>
                  <td> <input type="number" class="form-control <?php echo isset($_SESSION["usageLimit_class"]) ? $_SESSION["usageLimit_class"] : ''; ?>" name="usageLimit" value="<?= $row["usage_limit"] ?>">
                    <?php if (isset($_SESSION["usageLimit_error"])) : ?>
                      <div class="text-danger text-error pt-2">
                        <?php echo $_SESSION["usageLimit_error"]; ?>
                      </div>
                      <?php unset($_SESSION["usageLimit_error"]);
                      unset($_SESSION["usageLimit_class"]); ?>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th class="py-2">狀態</th>
                  <td>
                    <div class=" row">
                      <div class="col-6">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="status" id="statusActive" value="active" <?php if ($row["status"] == 'active') echo 'checked'; ?>>
                          <label class="form-check-label" for="statusActive">
                            <span class="fw-semibold <?php echo isset($_SESSION["status_text_color"]) ? $_SESSION["status_text_color"] : ''; ?>">可使用</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-check">
                          <input class="form-check-input " type="radio" id="statusInactive" name="status" value="inactive" <?php if ($row["status"] == 'inactive') echo 'checked'; ?>>
                          <label class="form-check-label" for="statusInactive">
                            <span class="fw-semibold <?php echo isset($_SESSION["status_text_color"]) ? $_SESSION["status_text_color"] : ''; ?>">已停用</span>
                          </label>
                        </div>
                      </div>
                  </td>
                </tr>
              </table>
              <div class="d-flex justify-content-center gap-3 my-4">
                <button class="btn btn-primary fw-semibold" type="submit"><i class="fa-solid fa-pen-to-square"></i> 確認編輯</button>
                <a href="coupon-list.php?page=1&order=1" class="btn btn-danger fw-semibold" role="button"><i class="fa-solid fa-trash"></i> 取消編輯</a>
              </div>
            </form>
          <?php else : ?>
            <h1>優惠卷不存在</h1>
          <?php endif; ?>
        </div>
      </div>
    </div>


    <script>
      // 生成包含大寫字母和數字的10碼隨機折扣碼
      document.getElementById("randomCode").addEventListener("click", function() {
        var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        var code = '';
        for (var i = 0; i < 10; i++) {
          var randomIndex = Math.floor(Math.random() * characters.length);
          code += characters[randomIndex];
        }
        document.getElementById("discountCode").value = code;
      });

      // 根據用戶選擇的折扣類型顯示相應的輸入框並清空折扣值
      document.querySelectorAll('input[name="discountType"]').forEach(function(elem) {
        elem.addEventListener("click", function() {
          if (elem.value == "percent") {
            document.getElementById("cashDiscountValueDiv").style.display = "none";
            document.getElementById("percentDiscountValueDiv").style.display = "block";
            document.getElementById("cashDiscountValue").value = "";
          } else if (elem.value == "cash") {
            document.getElementById("cashDiscountValueDiv").style.display = "block";
            document.getElementById("percentDiscountValueDiv").style.display = "none";
            document.querySelector('input[name="percentDiscountValue"]').value = "";
            document.querySelector('input[name="percentDiscountValue"]').value = "";
          }
        })
      });

      // 頁面加載時顯示預設輸入框並清空折扣值
      window.onload = function() {
        var discountType = "<?= $row["discount_type"] ?>";
        if (discountType == "cash") {
          document.getElementById("cashDiscountValueDiv").style.display = "block";
          document.getElementById("percentDiscountValueDiv").style.display = "none";
          document.querySelector('input[name="percentDiscountValue"]').value = "";
        } else if (discountType == "percent") {
          document.getElementById("cashDiscountValueDiv").style.display = "none";
          document.getElementById("percentDiscountValueDiv").style.display = "block";
          document.getElementById("cashDiscountValue").value = "";
        }
      }

      // 防止日期選擇至起始日之前
      document.getElementById("validFrom").addEventListener("change", function() {
        document.getElementById("validTo").min = document.getElementById("validFrom").value;
      });
      document.getElementById("validTo").addEventListener("change", function() {
        document.getElementById("validFrom").max = document.getElementById("validFrom").value;
      });
    </script>

    <?php include("../js-mahjong.php") ?>

</body>

</html>