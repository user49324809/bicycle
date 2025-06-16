<?php
require_once('include/auth_check.php');
require_once('include/db.php');

if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];

    // Подключение к базе
    $conn = openDbConnection();

    // Запрос на удаление заказа
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: orders.php"); // Перенаправляем на список заказов после удаления
        exit;
    } else {
        echo "Ошибка при удалении заказа: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Не указан ID заказа для удаления!";
    exit;
}
?>

