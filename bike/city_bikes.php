<?php
session_start();
include('init.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/category.php");
// переход в нужуню категорию
$conn = openDbConnection();
$products = getProductsByCategory($conn, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="category/card.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container{
            max-width: 100% !important;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <div class="container px-0">
        <?php include('header.php'); ?>
            <div class="category-products" id="city_bikes">
                <h3>Городские велосипеды</h3>
                <p>Городские велосипеды созданы для комфортных поездок по асфальтированным дорогам и городским маршрутам.</p>
                <div class="container py-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <div class="card border-0 shadow-sm h-100">
                                    <a href="city_bikes.php?product=<?= (int)$product['id'] ?>" class="text-decoration-none">
                                        <img src="<?= htmlspecialchars($product['image'] ?? '') ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-dark mb-2"><?= htmlspecialchars($product['title']) ?></h6>
                                        <p class="text-muted small mb-2"><?= htmlspecialchars($product['description'] ?? '') ?></p>
                                        <div class="mb-2">
                                            <strong>Цена:</strong> <?= number_format((int)$product['price'], 0, ',', ' ') ?> ₽ 
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted small">В наличии: <?= (int)($product['quantity'] ?? 0) ?> шт.</span>
                                        </div>
                                        <form method="POST" action="/source/cart.php" class="mt-auto">
                                            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                                            <div class="input-group mb-2" style="max-width: 120px;">
                                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm">
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
</body>
</html>