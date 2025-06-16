<?php include('include/header.php'); ?>
<?php
require_once('include/auth_check.php');
require_once('include/db.php');

$success = '';
$error = '';

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;

    if ($title && $category_id && $price > 0 && $image) {
        $conn = openDbConnection();

        $sql = "INSERT INTO bike_products (category_id, title, description, image, price)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = 'Ошибка подготовки запроса: ' . $conn->error;
        } else {
            // bind_param: 'isssd' => int, string, string, string, double
            $stmt->bind_param("isssd", $category_id, $title, $description, $image, $price);

            if ($stmt->execute()) {
                $success = 'Товар успешно добавлен!';
            } else {
                $error = 'Ошибка при добавлении товара: ' . $stmt->error;
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
    <h2>Добавить товар</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Категория</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Выберите категорию --</option>
                <option value="1">Горные</option>
                <option value="2">Шоссейные</option>
                <option value="3">Городские</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Название товара</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Путь к изображению</label>
            <input type="text" name="image" class="form-control" placeholder="например, images/bike3.jpg" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Цена (₽)</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-success">Добавить товар</button>
        <a href="index.php" class="btn btn-secondary">Назад</a>
    </form>
</div>

<?php include('include/footer.php'); ?>


