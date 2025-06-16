<?php
session_start();
require_once('db.php');

// Проверка, существует ли корзина в сессии
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Получаем данные пользователя (например, ID из сессии)
    $customer_id = $_SESSION['user_id']; // Предполагаем, что ID пользователя хранится в сессии

    // Подключаемся к базе данных
    include('db.php');
    $conn = openDbConnection();
    
    // Перебираем товары в корзине
    foreach ($_SESSION['cart'] as $product_id => $cart_item) {
        // Получаем информацию о товаре из базы данных
        $query = "SELECT title, price FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product_result = $stmt->get_result();
        $product = $product_result->fetch_assoc();

        // Информация о товаре и количестве
        $product_title = $product['title'];
        $product_price = $product['price'];
        $quantity = $cart_item['quantity'];
        $total_price = $product_price * $quantity;
        $status = 'Ожидает';  // Статус заказа

        // Вставляем заказ в таблицу orders
        $query = "INSERT INTO orders (customer_id, product, price, quantity, total_price, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isdiis", $customer_id, $product_title, $product_price, $quantity, $total_price, $status);
        $stmt->execute();
    }

    // Очищаем корзину после оформления заказа
    unset($_SESSION['cart']);
    
    // Перенаправляем на страницу с подтверждением
    header("Location: /order_confirmation.php");
    exit();
} else {
    echo "Ваша корзина пуста.";
}
?>
