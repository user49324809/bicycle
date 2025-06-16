<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");
$conn = openDbConnection();

// Инициализация корзины
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = $_SESSION['cart'];

// Обработка оформления заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['bike'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bikeModel = mysqli_real_escape_string($conn, $_POST['bike']);

    if (!empty($_SESSION['cart'])) {
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $date = date('Y-m-d');
        $status = 'Ожидает';

        $query = "INSERT INTO orders_clients (date, status, price, name, email, bike_model) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdsss", $date, $status, $totalPrice, $name, $email, $bikeModel);

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;

            foreach ($_SESSION['cart'] as $productId => $item) {
                $productPrice = $item['price'];
                $quantity = $item['quantity'];
                $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiid", $orderId, $productId, $quantity, $productPrice);
                $stmt->execute();
            }

            $_SESSION['cart'] = [];
            header('Location: /connect/order_confirmation.php');
            exit();
        } else {
            echo "Ошибка при создании заказа: " . $conn->error;
        }
    } else {
        echo "Ваша корзина пуста!";
    }
}

// Получение рекомендованных товаров
$recommendedAccessories = [];
$result = $conn->query("SELECT * FROM recommended_accessories");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recommendedAccessories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link rel="stylesheet" href="../main/header.css">
    <link rel="stylesheet" href="../main/footer.css">
    <link rel="stylesheet" href="../main/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 100%; margin: 0 auto; padding: 0 20px; }
    </style>
</head>
<body>
<div class="container">
    <?php include('../header.php'); ?>
    <h2>Ваша корзина</h2>

    <?php if (empty($cart)): ?>
        <p>Корзина пуста.</p>
    <?php else: ?>
        <?php $total = 0; ?>
        <?php foreach ($cart as $productId => $item): ?>
            <div class="cart-item d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-3">
                <div class="d-flex align-items-center">
                    <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" style="max-width: 100px;" class="me-3 rounded">
                    <div>
                        <h5><?= htmlspecialchars($item['title'] ?? '') ?></h5>
                        <p class="text-muted">Цена: <?= number_format($item['price'], 0, ',', ' ') ?> руб.</p>
                        <div class="d-flex align-items-center">
                            <a href="?decrease=<?= $productId ?>" class="btn btn-outline-secondary btn-sm">−</a>
                            <span class="mx-3"><?= htmlspecialchars($item['quantity']) ?></span>
                            <a href="?increase=<?= $productId ?>" class="btn btn-outline-secondary btn-sm">+</a>
                        </div>
                    </div>
                </div>
                <strong><?= number_format($item['price'] * $item['quantity'], 0, ',', ' ') ?> руб.</strong>
            </div>
            <?php $total += $item['price'] * $item['quantity']; ?>
        <?php endforeach; ?>
        <div class="cart-total mb-5">
            <h3>Итого: <?= number_format($total, 0, ',', ' ') ?> руб.</h3>
        </div>
        <div class="delivery-request mb-5">
            <div class="card p-4 bg-light shadow-lg">
                <h4 class="mb-3 text-center">Оформить заявку на покупку</h4>
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name">Имя:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <label for="bike">Модель велосипеда:</label>
                    <select name="bike" class="form-select mb-3" required>
                        <option disabled selected>Выберите модель</option>
                        <option value="mountain-bike">Горный</option>
                        <option value="road-bike">Шоссейный</option>
                        <option value="electric-bike">Электро</option>
                    </select>
                    <div class="text-center">
                        <button class="btn btn-primary px-4">Оформить заказ</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <h3 class="mt-5">Рекомендуем к вашему выбору</h3>
    <div class="row">
        <?php foreach ($recommendedAccessories as $acc): ?>
            <div class="col-md-3 mb-4">
                <div class="card shadow">
                    <img src="<?= htmlspecialchars($acc['image']) ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($acc['title']) ?></h5>
                        <p><?= htmlspecialchars($acc['price']) ?> руб.</p>
                        <a href="/connect/cart.php?add=<?= $acc['id'] ?>" class="btn btn-primary">Добавить</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include('../footer.php'); ?>
</div>
</body>
</html>



