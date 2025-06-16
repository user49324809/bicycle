<?php
// Получение данных о заказах из базы данных
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

$latestOrders = [];
if ($result->num_rows > 0) {
    // Преобразуем результат в массив
    while($row = $result->fetch_assoc()) {
        $latestOrders[] = $row;
    }
}
