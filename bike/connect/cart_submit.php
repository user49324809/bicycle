<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $bike = htmlspecialchars(trim($_POST['bike']));
    if (empty($name) || empty($email) || empty($bike)) {
        die("Пожалуйста, заполните все поля.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Неверный формат email.");
    }
    // Адрес, куда придёт заявка
    $to = "inna6903zaharova@yandex.ru";
    $subject = "Новая заявка на покупку велосипеда";
    $message = "
        <h3>Новая заявка</h3>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Модель велосипеда:</strong> $bike</p>
    ";
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: inna6903zaharova@yandex.ru\r\n";
    if (mail($to, $subject, $message, $headers)) {
        echo "Заявка успешно отправлена!";
    } else {
        echo "Ошибка при отправке заявки.";
    }
} else {
    echo "Некорректный метод запроса.";
}

