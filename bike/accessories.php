<?php
session_start();
include('init.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/category.php");
// Проверка атворизации
$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;
// Подключение к БД
$conn = openDbConnection();
$products = getProductsByCategory($conn, 5);
// Применение скидки при авторизации
foreach ($products as &$product) {
    if ($is_logged_in && isset($product['discount_for_registered']) && $product['discount_for_registered'] > 0) {
        // Получение скидки
        $discount_percentage = $product['discount_for_registered'];
        $product['price_with_discount'] = $product['price'] * (1 - $discount_percentage / 100);
    } else {
        //Цена для остальных товаров
        $product['price_with_discount'] = $product['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Документ</title>
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="category/card.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 100% !important;
            margin: 0 auto;
            padding: 0 20px;
        }
        .product-price {
            font-size: 1.2em;
        }
        .discount-price {
            color: green;
            font-weight: bold;
        }
        .original-price {
            text-decoration: line-through;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container px-0">
        <?php include('header.php'); ?>
            <div class="category-products" id="accessories">
                <h3>Аксессуары</h3>
                <p>Аксессуары для велосипедов: всё для вашего комфорта и безопасности.</p>
                <div class="container py-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php foreach ($products as &$product): ?>
                            <div class="col">
                                <div class="card border-0 shadow-sm h-100">
                                    <a href="accessories.php?product=<?= (int)$product['id'] ?>" class="text-decoration-none">
                                        <img src="<?= htmlspecialchars($product['image'] ?? '') ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-dark mb-2"><?= htmlspecialchars($product['title']) ?></h6>
                                        <p class="text-muted small mb-2"><?= htmlspecialchars($product['description'] ?? '') ?></p>
                                        <div class="mb-2">
                                            <strong>Цена:</strong> 
                                            <?php if ($is_logged_in && isset($product['price_with_discount']) && $product['price_with_discount'] < $product['price']): ?>
                                                <!-- Цена с учётом скидки -->
                                                <span id="price-<?= (int)$product['id'] ?>" class="product-price">
                                                    <?= number_format($product['price_with_discount'], 0, ',', ' ') ?> ₽ 
                                                </span>
                                                <small class="text-success">Скидка <?= $discount_percentage ?>%</small>
                                            <?php else: ?>
                                                <!-- Обычная цена -->
                                                <span id="price-<?= (int)$product['id'] ?>" class="product-price">
                                                    <?= number_format($product['price'], 0, ',', ' ') ?> руб.
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted small">В наличии: <?= (int)($product['quantity'] ?? 0) ?> шт.</span>
                                        </div>
                                        <form method="POST" action="/source/cart.php" class="mt-auto">
                                            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                                            <div class="input-group mb-2" style="max-width: 120px;">
                                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" id="quantity-<?= (int)$product['id'] ?>" onchange="updatePrice(<?= (int)$product['id'] ?>)">
                                            </div>
                                            <button type="submit" name="add_to_cart" class="btn btn-outline-success w-100 btn-sm">
                                                Добавить в корзину
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php include('footer.php'); ?> 
    </div>
    <script>
        // Функция для обновления цены с учётом скидки
        function updatePrice(productId) {
            const quantity = document.getElementById(`quantity-${productId}`).value;
            //id товара
            const product = <?= json_encode($products); ?>.find(p => p.id === productId);
            // Для товаров со скидкой 
            let price = product.price_with_discount;
            // Итоговая цена
            const totalPrice = price * quantity;
            // Обновление цены
            document.getElementById(`price-${productId}`).innerText = totalPrice.toFixed(0) + ' руб.';
        }
    </script>
</body>
</html>



