<?php
require_once("../db_connect_mahjong.php");
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <title>add coupon</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <?php include("../css-mahjong.php") ?>
</head>

<body>
  <?php include("../nav.php") ?>
  <div class="container row justify-content-center main-content">
    <div class=" col-12 px-5">
      <div class="py-2">
        <a class="btn btn-primary" href="coupon-list.php?page=1&order=1"><i class="fa-solid fa-arrow-left"></i>
          <span class="fw-semibold">回優惠卷列表</span>
        </a>
      </div>

      <form action="doAddCoupon.php" method="post">
        <div class="pt-3">
          <label for="" class="form-label fw-semibold">優惠卷名稱：</label>
          <input type="text" class="form-control 
        <?php echo isset($_SESSION["name_class"]) ? $_SESSION["name_class"] : ''; ?>
        " id="name" name="name" value="<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ''; ?>" />
          <?php if (isset($_SESSION["name_error"])) : ?>
            <div class="text-danger text-error pt-2">
              <?php echo $_SESSION["name_error"]; ?>
            </div>
            <?php unset($_SESSION["name_error"]);
            unset($_SESSION["name_class"]); ?>
          <?php endif; ?>
        </div>

        <div class="pt-3">
          <label for="" class="form-label fw-semibold">優惠卷折扣碼：</label>
          <div class="input-group">
            <input type="text" class="form-control         
          <?php echo isset($_SESSION["discountCode_class"]) ? $_SESSION["discountCode_class"] : ''; ?>" id="discountCode" name="discountCode" value="<?php echo isset($_SESSION["discountCode"]) ? $_SESSION["discountCode"] : ''; ?>" />
            <button type="button" class="btn btn-primary fw-semibold" id="randomCode">生成隨機代碼</button>
          </div>
          <?php if (isset($_SESSION["discountCode_error"])) : ?>
            <div class="text-danger text-error pt-2">
              <?php echo $_SESSION["discountCode_error"]; ?>
            </div>
            <?php unset($_SESSION["discountCode_error"]);
            unset($_SESSION["discountCode_class"]); ?>
          <?php endif; ?>
        </div>
        <div class="pt-3">
          <label for="" class="form-label fw-semibold">優惠卷折扣類型：</label><br>
          <div class="pt-2 row">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="discountType" id="cashDiscount" value="cash" checked>
                <label class="form-check-label" for="cashDiscount">
                  <span class="fw-semibold <?php echo isset($_SESSION["discountType_text_color"]) ? $_SESSION["discountType_text_color"] : ''; ?>">金額折扣</span>
                </label>
              </div>
            </div>

            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="radio" id="percentDiscount" name="discountType" value="percent">
                <label class="form-check-label" for="">
                  <span class="fw-semibold <?php echo isset($_SESSION["discountType_text_color"]) ? $_SESSION["discountType_text_color"] : ''; ?>">%數折扣</span>
                </label>
              </div>
            </div>

          </div>
        </div>

        <div class="pt-3" id="cashDiscountValueDiv">
          <label for="" class="form-label fw-semibold">優惠卷折扣金額：</label>
          <div class="input-group">
            <div class="input-group-text">$</div>
            <input type="number" class="form-control           
          <?php echo isset($_SESSION["cashDiscountValue_class"]) ? $_SESSION["cashDiscountValue_class"] : ''; ?>" id="cashDiscountValue" name="cashDiscountValue" value="<?php echo isset($_SESSION["cashDiscountValue"]) ? $_SESSION["cashDiscountValue"] : ''; ?>">
          </div>
          <?php if (isset($_SESSION["cashDiscountValue_error"])) : ?>
            <div class="text-danger text-error pt-2">
              <?php echo $_SESSION["cashDiscountValue_error"]; ?>
            </div>
            <?php unset($_SESSION["cashDiscountValue_error"]);
            unset($_SESSION["cashDiscountValue_class"]); ?>
          <?php endif; ?>
        </div>

        <div class="pt-3" id="percentDiscountValueDiv">
          <label for="" class="form-label fw-semibold">優惠卷折扣百分比：</label>
          <div class="input-group">
            <input type="number" value="percent" min="0" max="100" class="form-control           
          <?php echo isset($_SESSION["percentDiscountValue_class"]) ? $_SESSION["percentDiscountValue_class"] : ''; ?>" id="percentDiscountValue" name="percentDiscountValue" value="<?php echo isset($_SESSION["percentDiscountValue"]) ? $_SESSION["percentDiscountValue"] : ''; ?>">
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

        <div class="pt-3 row">
          <div class="col-6">
            <label for="" class="form-label fw-semibold">有效起始日：</label>
            <input type="date" class="form-control  
          <?php echo isset($_SESSION["validFrom_class"]) ? $_SESSION["validFrom_class"] : ''; ?>" name="validFrom" id="validFrom" value="<?php echo isset($_SESSION["validFrom"]) ? $_SESSION["validFrom"] : ''; ?>">
            <?php if (isset($_SESSION["validFrom_error"])) : ?>
              <div class="text-danger text-error pt-2">
                <?php echo $_SESSION["validFrom_error"]; ?>
              </div>
              <?php unset($_SESSION["validFrom_error"]);
              unset($_SESSION["validFrom_class"]); ?>
            <?php endif; ?>
          </div>
          <div class="col-6">
            <label for="" class="form-label fw-semibold">有效截止日：</label>
            <input type="date" class="form-control           
          <?php echo isset($_SESSION["validTo_class"]) ? $_SESSION["validTo_class"] : ''; ?>" name="validTo" id="validTo" value="<?php echo isset($_SESSION["validTo"]) ? $_SESSION["validTo"] : ''; ?>">
            <?php if (isset($_SESSION["validTo_error"])) : ?>
              <div class="text-danger text-error pt-2">
                <?php echo $_SESSION["validTo_error"]; ?>
              </div>
              <?php unset($_SESSION["validTo_error"]);
              unset($_SESSION["validTo_class"]);  ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="pt-3">
          <label for="" class="form-label fw-semibold">使用最低消費金額：</label>
          <div class="input-group">
            <div class="input-group-text">$</div>
            <input type="text" class="form-control 
        <?php echo isset($_SESSION["limitValue_class"]) ? $_SESSION["limitValue_class"] : ''; ?>
        " name="limitValue" id="limitValue" value="<?php echo isset($_SESSION["limitValue"]) ? $_SESSION["limitValue"] : ''; ?>">
          </div>
          <?php if (isset($_SESSION["limitValue_error"])) : ?>
            <div class="text-danger text-error pt-2">
              <?php echo $_SESSION["limitValue_error"]; ?>
            </div>
            <?php unset($_SESSION["limitValue_error"]);
            unset($_SESSION["limitValue_class"]); ?>
          <?php endif; ?>
        </div>
        <div class="pt-3">
          <label for="" class="form-label fw-semibold">可使用次數：</label>
          <input type="text" class="form-control         
        <?php echo isset($_SESSION["usageLimit_class"]) ? $_SESSION["usageLimit_class"] : ''; ?>
        " name="usageLimit" id="usageLimit" value="<?php echo isset($_SESSION["usageLimit"]) ? $_SESSION["usageLimit"] : ''; ?>">
          <?php if (isset($_SESSION["usageLimit_error"])) : ?>
            <div class="text-danger text-error pt-2">
              <?php echo $_SESSION["usageLimit_error"]; ?>
            </div>
            <?php unset($_SESSION["usageLimit_error"]);
            unset($_SESSION["usageLimit_class"]); ?>
          <?php endif; ?>
        </div>
        <div class="d-flex justify-content-center gap-3 my-4">
          <button class="btn btn-primary fw-semibold" type="submit"><i class="fa-solid fa-check"></i> 創建</button>
          <a href="coupon-list.php?page=1&order=1" class="btn btn-danger fw-semibold" role="button"><i class="fa-solid fa-trash"></i> 取消創建</a>
        </div>
      </form>
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

    // 根據用戶選擇的折扣類型顯示相應的輸入框
    document.querySelectorAll('input[name="discountType"]').forEach(function(elem) {
      elem.addEventListener("click", function() {
        if (elem.value == "percent") {
          document.getElementById("cashDiscountValueDiv").style.display = "none";
          document.getElementById("percentDiscountValueDiv").style.display = "block";

        } else if (elem.value == "cash") {
          document.getElementById("cashDiscountValueDiv").style.display = "block";
          document.getElementById("percentDiscountValueDiv").style.display = "none";
        }
      })
    });

    // 頁面加載時預設顯示金額折扣輸入框
    window.onload = function() {
      document.getElementById("cashDiscountValueDiv").style.display = "block";
      document.getElementById("percentDiscountValueDiv").style.display = "none";
    }

    // 防止日期選擇至起始日之前
    document.getElementById("validFrom").addEventListener("change", function() {
      document.getElementById("validTo").min = document.getElementById("validFrom").value;
    });
    document.getElementById("validTo").addEventListener("change", function() {
      document.getElementById("validFrom").max = this.value;
    });
  </script>

  <!-- Bootstrap JavaScript Libraries -->
  <?php include("../js-mahjong.php"); ?>
</body>

</html>