<?php
session_start();
include('init.php');
require_once('connect/db.php');
require_once('connect/category.php');
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true)) {
    header("Location: login.php");
    exit();
}
$orders = selectOrders();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="personal/personal_cabinet.css">
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body>
<?php include('header.php'); ?>

<div class="container my-4">
    <!-- Навигационные вкладки -->
    <ul class="nav nav-pills mb-4" id="profileTabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#profileTab">Мой профиль</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ordersTab">Мои заказы</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#settingsTab">Настройки</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#discountsTab">Актуальные скидки</a></li>
    </ul>
    <div class="tab-content">
        <!-- Профиль -->
        <div class="tab-pane fade show active" id="profileTab">
            <h2>Мой профиль</h2>
            <div id="profileView">
                <p id="nameDisplay">Имя: <?= $_SESSION['login']; ?></p>
                <p id="emailDisplay">Email: <?= $_SESSION['email']; ?></p>
                <button class="btn btn-primary" onclick="enableEdit()">Редактировать</button>
            </div>
            <div id="profileEdit" style="display: none;">
                <div class="mb-2">
                    <label class="form-label">Имя:</label>
                    <input type="text" id="nameInput" class="form-control" value="<?= $_SESSION['login']; ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Email:</label>
                    <input type="email" id="emailInput" class="form-control" value="<?= $_SESSION['email']; ?>">
                </div>
                <button class="btn btn-success" onclick="saveEdit()">Сохранить</button>
                <button class="btn btn-secondary" onclick="cancelEdit()">Отмена</button>
            </div>
        </div>
        <!-- Заказы -->
        <div class="tab-pane fade" id="ordersTab">
            <h2>Мои заказы</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['id']) ?></td>
                            <td><?= date("d.m.Y", strtotime($order['date'])) ?></td>
                            <td>
                                <form method="post" action="update_status.php" class="d-flex align-items-center">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                        <option value="Ожидает" <?= $order['status'] === 'Ожидает' ? 'selected' : '' ?>>Ожидает</option>
                                        <option value="Завершён" <?= $order['status'] === 'Завершён' ? 'selected' : '' ?>>Завершён</option>
                                        <option value="Другой" <?= $order['status'] === 'Другой' ? 'selected' : '' ?>>Другой</option>
                                    </select>
                                    <span class="badge bg-<?= 
                                        $order['status'] === 'Ожидает' ? 'warning' : 
                                        ($order['status'] === 'Завершён' ? 'success' : 'secondary') ?>">
                                        <?= htmlspecialchars($order['status']) ?>
                                    </span>
                                </form>
                            </td>
                            <td><?= number_format($order['price'], 2, ',', ' ') ?> ₽</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Настройки -->
        <div class="tab-pane fade" id="settingsTab">
            <h2>Настройки</h2>
            <button class="btn btn-secondary">Изменить настройки</button>
        </div>
        <!-- Скидки -->
        <div class="tab-pane fade" id="discountsTab">
            <h2 class="mb-4">🔥 Актуальные скидки</h2>
            <!-- скидки - карточки -->
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 discount-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-tags-fill text-danger me-2"></i>Скидка 30% на аксесуары!</h5>
                            <p class="card-text">Действует до <strong>30 апреля 2025</strong>. Промокод: <span class="badge bg-danger">SPRING30</span></p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <button class="btn btn-outline-danger w-100" onclick="document.location='accessories.php'">Использовать</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 discount-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-gift-fill text-success me-2"></i>Бонус 500 ₽ за первую покупку!</h5>
                            <p class="card-text">Только для новых клиентов. Получите дополнительную выгоду прямо сейчас.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <button class="btn btn-outline-success w-100">Подробнее</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script src="./JS/edit_personal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


