<?php
require_once("../db_connect_mahjong.php");
session_start();

if (!isset($_POST["name"])) {
  die("請循正常管道進入此頁");
}

$name = $_POST["name"];
$discountCode = $_POST["discountCode"];
$discountType = $_POST["discountType"];
$percentDiscountValue = $_POST["percentDiscountValue"];
$cashDiscountValue = $_POST["cashDiscountValue"];
$validFrom = $_POST["validFrom"];
$validTo = $_POST["validTo"];
$limitValue = $_POST["limitValue"];
$usageLimit = $_POST["usageLimit"];


$sqlCheckCoupon = "SELECT * FROM coupons WHERE discount_code = '$discountCode'";
$resultCheck = $conn->query($sqlCheckCoupon);


if ($resultCheck->num_rows > 0) {
  $errorMsg = "此優惠券已被生成。";
  $_SESSION["discountCode_error"] = $errorMsg;
  $_SESSION["discountCode_class"] = "is-invalid";
  header("location:add-Coupon.php");
}

if (empty($name)) {
  $errorMsg = "請輸入優惠卷名稱。";
  $_SESSION["name_error"] = $errorMsg;
  $_SESSION["name_class"] = "is-invalid";
  $_SESSION["name"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["name"] = $name;
  $_SESSION["name_class"] = "is-valid";
}

if (empty($discountCode)) {
  $errorMsg = "請輸入優惠卷代碼。";
  $_SESSION["discountCode_error"] = $errorMsg;
  $_SESSION["discountCode_class"] = "is-invalid";
  $_SESSION["discountCode"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["discountCode"] = $discountCode;
  $_SESSION["discountCode_class"] = "is-valid";
}

if ($discountType == "percent") {
  $_SESSION["discountType_text_color"] = "text-success";
} elseif ($discountType == 'cash') {
  $_SESSION["discountType_text_color"] = "text-success";
}

if ($discountType == "percent") {
  if (empty($percentDiscountValue)) {
    $errorMsg = "請輸入優惠卷折扣值。";
    $_SESSION["percentDiscountValue_error"] = $errorMsg;
    $_SESSION["percentDiscountValue_class"] = "is-invalid";
    $_SESSION["percentDiscountValue"] = "";
    header("location:add-Coupon.php");
  } else {
    $_SESSION["percentDiscountValue"] = $percentDiscountValue;
    $_SESSION["percentDiscountValue_class"] = "is-valid";
  }
} else if ($discountType == "cash") {
  if (empty($cashDiscountValue)) {
    $errorMsg = "請輸入優惠卷折扣值。";
    $_SESSION["cashDiscountValue_error"] = $errorMsg;
    $_SESSION["cashDiscountValue_class"] = "is-invalid";
    $_SESSION["cashDiscountValue"] = "";
    header("location:add-Coupon.php");
  } else {
    $_SESSION["cashDiscountValue"] = $cashDiscountValue;
    $_SESSION["cashDiscountValue_class"] = "is-valid";
  }
}

if (empty($validFrom)) {
  $errorMsg = "請選擇優惠卷有效起始日。";
  $_SESSION["validFrom_error"] = $errorMsg;
  $_SESSION["validFrom_class"] = "is-invalid";
  $_SESSION["validFrom"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["validFrom"] = $validFrom;
  $_SESSION["validFrom_class"] = "is-valid";
}

if (empty($validTo)) {
  $errorMsg = "請選擇優惠卷有效截止日。";
  $_SESSION["validTo_error"] = $errorMsg;
  $_SESSION["validTo_class"] = "is-invalid";
  $_SESSION["validTo"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["validTo"] = $validTo;
  $_SESSION["validTo_class"] = "is-valid";
}

if (empty($limitValue)) {
  $errorMsg = "請輸入使度優惠卷限制金額。";
  $_SESSION["limitValue_error"] = $errorMsg;
  $_SESSION["limitValue_class"] = "is-invalid";
  $_SESSION["limitValue"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["limitValue"] = $limitValue;
  $_SESSION["limitValue_class"] = "is-valid";
}

if (empty($usageLimit)) {
  $errorMsg = "請輸入優惠卷可使用次數。";
  $_SESSION["usageLimit_error"] = $errorMsg;
  $_SESSION["usageLimit_class"] = "is-invalid";
  $_SESSION["usageLimit"] = "";
  header("location:add-Coupon.php");
} else {
  $_SESSION["usageLimit"] = $usageLimit;
  $_SESSION["usageLimit_class"] = "is-valid";
}

if (!isset($_SESSION["name_error"]) && !isset($_SESSION["discountCode_error"]) && !isset($_SESSION["percentDiscountValue_error"]) && !isset($_SESSION["cashDiscount) _error"]) && !isset($_SESSION["validFrom_error"]) && !isset($_SESSION["validTo_error"]) && !isset($_SESSION["limitValue_error"]) && !isset($_SESSION["usageLimit_error"])) {

  $discountValue = $discountType == "percent" ? $percentDiscountValue : $cashDiscountValue;
  $sql = "INSERT INTO coupons (name, discount_code, discount_type, discount_value, valid_from, valid_to, limit_value, usage_limit,status) VALUES ('$name', '$discountCode', '$discountType', '$discountValue', '$validFrom', '$validTo', '$limitValue', '$usageLimit','active')";

  if ($conn->query($sql) === TRUE) {
    $successMsg = "優惠卷新增成功。";
    $_SESSION["successMsg"] = $successMsg;
    session_unset();
    header("location:coupon-list.php?page=1&order=1");
    exit();
  } else {
    $errorMsg = "優惠卷新增失敗: " . $conn->error;
    $_SESSION["errorMsg"] = $errorMsg;
  }
}

header("location:add-Coupon.php");
exit();
