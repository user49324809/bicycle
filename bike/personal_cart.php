<?php
session_start();
require_once('connect/db.php');

// Проверка, что пользователь авторизован
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true)) {
    header("Location: login.php");
    exit();
}

// Подключение к базе данных
$conn = openDbConnection();

// Получаем ID пользователя из сессии
$user_id = $_SESSION['id']; 

// Пример данных о заказе (замените на реальную информацию)
$customer_name = $_SESSION['login']; // Имя покупателя
$product = "Пример товара"; // Название товара
$price = 1000.00;    // Сумма заказа
$quantity = 2;       // Количество товара
$status = 'Ожидает'; // Статус заказа
$date = time();      // Время оформления заказа (текущее время)

// Запрос для вставки нового заказа в базу данных
$query = "INSERT INTO orders (customer_name, product, price, quantity, date, status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdiisi", $customer_name, $product, $price, $quantity, $date, $status, $user_id);
$stmt->execute();

// Закрытие соединения
$stmt->close();
$conn->close();
?>
