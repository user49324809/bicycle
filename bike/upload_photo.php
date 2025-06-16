<?php
session_start();
require_once('connect/db.php');
require_once('connect/category.php');

// Проверка авторизации
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !isset($_SESSION['login'])) {
    die("Вы не авторизованы или не выбран пользователь");
}

// Получаем логин пользователя из сессии
$userLogin = $_SESSION['login'];

$conn = openDbConnection();

// Проверка, был ли загружен файл
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    
    // Проверка и создание директории для загрузки
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Создаем директорию, если она не существует
    }

    $filename = uniqid() . "_" . basename($_FILES['photo']['name']);
    $targetPath = $uploadDir . $filename;

    // Перемещение загруженного файла
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        $caption = htmlspecialchars($_POST['caption']);

        // Сохраняем фото с привязкой к логину пользователя
        $stmt = $conn->prepare("INSERT INTO user_photos (login, photo_path, caption, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $userLogin, $targetPath, $caption);

        if ($stmt->execute()) {
            header("Location: personal_cabinet.php#impressionsTab");
            exit();
        } else {
            echo "Ошибка при сохранении в БД: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при загрузке файла.";
    }
} else {
    echo "Нет файла для загрузки.";
}






