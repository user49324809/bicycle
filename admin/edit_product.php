<?php 
include('include/header.php'); 
require_once('include/auth_check.php'); 
require_once('show_products.php'); 
require_once('show_categories.php'); 
require_once('include/db.php'); 
require_once('include/product_functions.php');
$success = '';
$error = '';

$conn = openDbConnection();
$products = selectAllProductsWithCategories();
//$category = updateProductById();
// Получаем ID редактируемого товара
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ищем товар с нужным ID
foreach ($products as $product) {
    if ($product['id'] == $id) {
        break;
    }
}

if (!$product) {
    $error = 'Товар не найден.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $price = (int)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = trim($_POST['image']);

    if ($name && $category && $price > 0 && $stock >= 0 && $image) {
        // Функция для обновления товара — должна быть реализована в db.php
        $result = updateProductById($id, $name, $category, $price, $stock, $image);
        if ($result) {
            $success = 'Товар успешно обновлён!';
            // Обновляем текущий товар для отображения новых данных
            $product = [
                'id' => $id,
                'name' => $name,
                'category' => $category,
                'price' => $price,
                'stock' => $stock,
                'image' => $image,
            ];
        } else {
            $error = 'Ошибка при обновлении товара.';
        }
    } else {
        $error = 'Заполните все поля корректно.';
    }
}
?>

<div class="container py-4">
    <h2>Редактировать товар</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($product): ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars(isset($product['name']) ? $product['name'] : ''); ?>"
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select name="category" class="form-control">
                    <?php
                    $categories = selectAllCategories(); // функция должна возвращать массив всех категорий
                    foreach ($categories as $cat) {
                        $selected = ($cat['id'] == $product['category_id']) ? 'selected' : '';
                        echo "<option value=\"{$cat['id']}\" $selected>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">В наличии</label>
                <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($product['stock'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Путь к изображению</label>
                <input type="text" name="image" class="form-control" value="<?= $product['image'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="index.php" class="btn btn-secondary">Назад</a>
        </form>
    <?php endif; ?>
</div>

<?php include('include/footer.php'); ?>

