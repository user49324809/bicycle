<?php
require_once('include/auth_check.php');
require_once('include/db.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/show_categories.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/show_products.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/show_orders.php");
include('include/header.php');
// Подключение к базе
$conn = openDbConnection();

// Получаем список категорий велосипедов
$categories = selectAllCategories();
$products = selectAllProductsWithCategories();
$latestProducts = $categories; // используем уже полученные данные

// Заглушка для заказов
$orders = selectAllOrders();

// Получение количества товаров
$sqlProducts = "SELECT COUNT(*) AS totalProducts FROM bike_products";
$resultProducts = mysqli_query($conn, $sqlProducts);
$totalProducts = mysqli_fetch_assoc($resultProducts)['totalProducts'];

// Получение количества заказов
$sqlOrders = "SELECT COUNT(*) AS totalOrders FROM orders";
$resultOrders = mysqli_query($conn, $sqlOrders);
$totalOrders = mysqli_fetch_assoc($resultOrders)['totalOrders'];

// Получение количества пользователей
$sqlUsers = "SELECT COUNT(*) AS totalUsers FROM users";
$resultUsers = mysqli_query($conn, $sqlUsers);
$totalUsers = mysqli_fetch_assoc($resultUsers)['totalUsers'];

// Получение количества заказов, которые ожидают отправки
$sqlPendingOrders = "SELECT COUNT(*) AS pendingOrders FROM orders WHERE status = 'Ожидает'";
$resultPendingOrders = mysqli_query($conn, $sqlPendingOrders);
$pendingOrders = mysqli_fetch_assoc($resultPendingOrders)['pendingOrders'];

?>

<div class="container-fluid py-4">
  <div class="row min-vh-80 h-100">
    <div class="col-12">
      <h2 class="mb-4">Админ-панель магазина велосипедов</h2>
      <div class="row mb-4">
        <!-- Карточки -->
        <div class="col-md-3">
          <div class="card text-white bg-success">
            <div class="card-body">
              <h5 class="card-title">Товары в наличии</h5>
              <p class="card-text fs-4"><?= $totalProducts ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-info">
            <div class="card-body">
              <h5 class="card-title">Заказы</h5>
              <p class="card-text fs-4"><?= $totalOrders ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-warning">
            <div class="card-body">
              <h5 class="card-title">Ожидают отправки</h5>
              <p class="card-text fs-4"><?= $pendingOrders ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h5 class="card-title">Пользователи</h5>
              <p class="card-text fs-4"><?= $totalUsers ?></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Кнопка добавления товара -->
      <div class="mb-3">
        <a href="add_product.php" class="btn btn-success">Добавить товар</a>
      </div>
      <!-- Таблица товаров -->
      <div class="card mb-4">
        <div class="card-header">Список товаров с категориями</div>
        <div class="card-body table-responsive">
          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Действия</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
              <tr>
                <td><?= $product['id'] ?></td>
                <td><img src="assets/images/<?= $product['image'] ?>" alt="bike" width="60"></td>
                <td><?= htmlspecialchars($product['product_title']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['category_name']) ?></td>
                <td><?= number_format($product['price'], 2, '.', ' ') ?> ₽</td>
                <td>
                  <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                  <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить этот товар?')">Удалить</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Таблица заказов (заглушка) -->
      <div class="card mb-4">
        <div class="card-header">Последние заказы</div>
        <div class="card-body table-responsive">
          <!-- Кнопка добавления товара -->
          <div class="mb-3">
            <a href="add_order.php" class="btn btn-success">Добавить товар</a>
          </div>
          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>№ Заказа</th>
                <th>Клиент</th>
                <th>Товар</th>
                <th>Дата</th>
                <th>Статус</th>
                <th>Сумма</th>
                <th>Количество</th>
                <th>Действия</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
              <tr>
                <td>#<?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['customer']) ?></td>
                <td><?= htmlspecialchars($order['product']) ?></td>
                <td><?= $order['date'] ?></td>
                <td>
                  <span class="badge bg-<?= $order['status'] === 'Ожидает' ? 'warning' : ($order['status'] === 'Завершён' ? 'success' : 'secondary') ?>">
                    <?= $order['status'] ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($order['price']) ?></td>
                <td><?= htmlspecialchars($order['quantity']) ?></td>
                <td>
                  <a href="view_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-primary">Просмотр</a>
                  <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                  <a href="delete_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить этот заказ?')">Удалить</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('include/footer.php'); ?>
