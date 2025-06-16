<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");

if (isset($_POST['order_id'], $_POST['status'])) {
    $conn = openDbConnection();

    $orderId = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $allowedStatuses = ['Ожидает', 'Завершён', 'Другой'];
    if (!in_array($status, $allowedStatuses)) {
        die("Недопустимый статус.");
    }

    $stmt = $conn->prepare("UPDATE orders_clients SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
