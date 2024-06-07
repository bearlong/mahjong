<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="py-2">
        <div class="d-flex justify-content-between">
            <?php
            require_once("category_fetch.php");
            // session_start();
            $cartCount = isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0;
            ?>
            <a class="cart-icon position-relative" href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount"><?= $cartCount ?></span>
            </a>
        </div>
    </header>
    <nav class="py-2">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="product-list.php">全部商品</a></li>
            <?php foreach ($cateRows as $category) : ?>
                <li class="nav-item"><a class="nav-link" href="product-list.php?category=<?= $category["id"] ?>"><?= $category["name"] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</body>

</html>