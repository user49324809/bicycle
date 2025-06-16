<?php
ini_set('memory_limit', '256M');

require_once('include/auth_check.php');
?>

<!-- Подключаем стили Bootstrap через CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand" href="#">Веломагазин — Админ</a>
</nav>

<!-- Проверяем, если пользователь авторизован, показываем приветственное сообщение -->
<?php if (isset($_SESSION['user'])): ?>
  <div class="d-flex justify-content-end">
    <p>Привет, <?= htmlspecialchars($_SESSION['user']) ?> | <a href="logout.php">Выйти</a></p>
  </div>
<?php endif; ?>

