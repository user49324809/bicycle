<?php
session_start();
include('init.php');
require_once('connect/db.php');

$login = trim(filter_var($_POST['login']), FILTER_SANITIZE_SPECIAL_CHARS);
$email = trim(filter_var($_POST['email']), FILTER_SANITIZE_SPECIAL_CHARS);
$pass = trim(filter_var($_POST['password']), FILTER_SANITIZE_SPECIAL_CHARS);

$hashedPass = password_hash($pass, PASSWORD_DEFAULT);
$conn = openDbConnection();

if (empty($login) || empty($email) || empty($pass)) {
    echo "Enter your correct data";
} else {
    // Проверяем, существует ли уже пользователь с таким именем
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `registr` WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Если количество > 0, значит пользователь с таким именем уже существует
        echo "Пользователь с таким именем уже существует.";
    } else {
        // Если пользователя нет, вставляем его в базу данных
        $stmt = $conn->prepare("INSERT INTO `registr` (login, email, pass) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $email, $hashedPass);

        if ($stmt->execute()) {
            echo "Вы успешно зарегистрированы!";
        } else {
            echo "Ошибка регистрации: " . $stmt->error;
        }

        $stmt->close();
    }
}
$conn->close();
?>

