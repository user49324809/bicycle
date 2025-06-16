<?php
require_once('include/auth_check.php');
require_once('include/db.php');
include('include/header.php');
// Подключение к базе
$conn = openDbConnection();
if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    // Получаем данные о заказе
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customer_name = trim($_POST['customer_name']);
        $product = trim($_POST['product']);
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $amount = $price * $quantity; // Считаем общую сумму
        // Подготовка запроса для обновления заказа
        $stmt = $conn->prepare("UPDATE orders SET customer_name = ?, product = ?, price = ?, quantity = ?, date = ?, status = ?, amount = ? WHERE id = ?");
        $stmt->bind_param("ssdiissi", $customer_name, $product, $price, $quantity, $date, $status, $amount, $order_id);
        if ($stmt->execute()) {
            header("Location: orders.php"); // Перенаправляем на список заказов после обновления
            exit;
        } else {
            echo "Ошибка при обновлении заказа: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Не указан ID заказа!";
    exit;
}
?>

<div class="container">
    <h2>Редактировать заказ</h2>
    <form action="edit_order.php?id=<?= $order['id'] ?>" method="POST">
        <div class="form-group">
            <label for="customer_name">Имя клиента</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= htmlspecialchars($order['customer_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="product">Название товара</label>
            <input type="text" class="form-control" id="product" name="product" value="<?= htmlspecialchars($order['product']) ?>" required>
        </div>
        <div class="form-group">
            <label for="quantity">Количество</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?= htmlspecialchars($order['quantity']) ?>" min="1" required>
        </div>
        <div class="form-group">
            <label for="price">Цена за единицу</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($order['price']) ?>" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="status">Статус</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Ожидает" <?= $order['status'] == 'Ожидает' ? 'selected' : '' ?>>Ожидает</option>
                <option value="Завершено" <?= $order['status'] == 'Завершено' ? 'selected' : '' ?>>Завершено</option>
                <option value="Отменено" <?= $order['status'] == 'Отменено' ? 'selected' : '' ?>>Отменено</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Дата</label>
            <input type="date" class="form-control" id="date" name="date" value="<?= $order['date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</div>

<?php include('include/footer.php'); ?>


