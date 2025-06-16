<?php include('include/header.php'); ?>
<?php
require_once('include/auth_check.php');
require_once('include/db.php');
$success = '';
$error = '';
// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $product = $_POST['product'] ?? '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $date = $_POST['date'] ?? '';
    $status = $_POST['status'] ?? '';
    if ($customer_name && $product && $price > 0 && $quantity > 0 && $date && $status) {
        $conn = openDbConnection();

        // SQL запрос для добавления данных
        $sql = "INSERT INTO orders (customer_name, product, price, quantity, date, status)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = 'Ошибка подготовки запроса: ' . $conn->error;
        } else {
            $stmt->bind_param("ssdiis", $customer_name, $product, $price, $quantity, $date, $status);
            // Выполнение запроса
            if ($stmt->execute()) {
                $success = 'Заказ успешно добавлен!';
            } else {
                $error = 'Ошибка при добавлении заказа: ' . $stmt->error;
            }
            $stmt->close();
        }
        $conn->close();
    } else {
        $error = 'Пожалуйста, заполните все обязательные поля корректно.';
    }
}



?>

<div class="container py-4">
    <h2>Добавить заказ</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Имя клиента</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Товар</label>
            <input type="text" name="product" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Цена (₽)</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Количество</label>
            <input type="number" name="quantity" class="form-control" required min="1">
        </div>
        <div class="mb-3">
            <label class="form-label">Дата заказа</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Статус</label>
            <select name="status" class="form-control" required>
                <option value="">-- Выберите статус --</option>
                <option value="Ожидает">Ожидает</option>
                <option value="Обработан">Обработан</option>
                <option value="Доставлен">Доставлен</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить заказ</button>
        <a href="index.php" class="btn btn-secondary">Назад</a>
    </form>
</div>

<?php include('include/footer.php'); ?>


