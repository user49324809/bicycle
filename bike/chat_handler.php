<?php
include('connect/db.php');
$conn = openDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $message = trim($_POST['message']);

    if ($username && $message) {
        saveChatMessage($conn, $username, $message);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Поля не должны быть пустыми']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $messages = getAllChatMessages($conn);
    echo json_encode($messages);
    exit;
}
?>
