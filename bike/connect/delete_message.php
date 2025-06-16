<?php
session_start();
require_once('db.php');

// Проверяем, был ли передан текст сообщения
if (isset($_POST['message']) && !empty($_POST['message'])) {
    $messageText = $_POST['message'];  // Получаем текст сообщения из POST-запроса

    // Подключаем базу данных
    $conn = openDbConnection();

    // Подготавливаем запрос на удаление сообщения по тексту
    $query = "DELETE FROM chat_messages WHERE message = ?";
    $stmt = $conn->prepare($query);

    // Привязываем параметр и выполняем запрос
    $stmt->bind_param("s", $messageText);
    $stmt->execute();

    // Закрываем соединение
    $stmt->close();
    $conn->close();

    // Перенаправляем пользователя обратно на страницу чата
    header('Location: ../chat.php');
    exit;
} else {
    // Если не был передан текст сообщения, перенаправляем назад
    header('Location: ../chat.php');
    exit;
}
?>

