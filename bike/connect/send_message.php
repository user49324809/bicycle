<?php
require_once('db.php');
$conn = openDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $message = trim($_POST['message']);

    if ($username && $message) {
        $stmt = $conn->prepare("INSERT INTO chat_messages (username, message) VALUES (?, ?)");
        $stmt->execute([$username, $message]);
    }
}

function logApprovedMessage(string $username, string $message): void {
    $logPath = '../violations.txt';
    $entry = trim($username) . '||' . trim($message) . PHP_EOL;
    file_put_contents($logPath, $entry, FILE_APPEND);
}


header("Location: ./chat.php");
exit;
