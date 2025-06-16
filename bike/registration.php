<?php
session_start();
include('init.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="main/login.css">
    <link rel="stylesheet" href="./main/header.css">
    <link rel="stylesheet" href="./main/footer.css">
</head>
<body>
    <div class="container">
        <form class="form_registr" action="register_handler.php" method="POST">
            <h2>Регистрация</h2>
            <label for="username">Имя пользователя</label>
            <input type="text" id="login" name="login" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="button_registr">Зарегистрироваться</button>
        </form>
    <?php include('footer.php'); ?>
    </div>
</body>
</html>

