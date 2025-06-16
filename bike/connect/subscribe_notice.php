<?php
// Подключение к базе данных
include('db.php');
$conn = openDbConnection();
// Проверка подключения к базе данных
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    // Проверка, что хотя бы одно поле заполнено
    if ($email || $phone) {
        // Запись в базу данных (таблица subscribers)
        $sql = "INSERT INTO subscribers (email, phone) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $phone);
        // Выполнение запроса
        if ($stmt->execute()) {
            echo "Вы успешно подписались на уведомления!";
        } else {
            echo "Ошибка при подписке на уведомления: " . $stmt->error;
        }
        // Закрытие соединения
        $stmt->close();
    } else {
        echo "Пожалуйста, укажите хотя бы один способ связи (email или телефон).";
    }
} else {
    echo "Неверный запрос.";
}

// Закрываем соединение с базой данных
$conn->close();
