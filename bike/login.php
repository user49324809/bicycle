<?php
session_start();
include('init.php');
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="main/login.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa; 
        }
        .container {
            max-width: 400px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .button {
            width: 100%;
        }
    </style>
</head>
<body>
    <form class="container" action="form_login.php" method="POST">
        <h2 class="text-center mb-4">Войти</h2>
        <label for="username" class="form-label">Имя пользователя</label>
        <input type="text" id="login" name="login" class="form-control mb-3" placeholder="Введите имя" required>

        <label for="password" class="form-label">Пароль</label>
        <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Введите пароль" required>

        <button type="submit" class="button btn btn-success btn-lg rounded-pill">Войти</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
