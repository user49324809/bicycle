<?php
session_start();
require_once('connect/db.php');
$conn = openDbConnection();
$chatMessages = getAllChatMessages($conn);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обсуждение мероприятия</title>
    <link rel="stylesheet" href="./main/header.css">
    <link rel="stylesheet" href="./main/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .chat-message {
        background-color: #f1f1f1;
        border-radius: 10px;
        padding: 10px;
        position: relative;
    }
    .chat-message strong {
        color: #0d6efd;
    }
    .reply-btn {
        font-size: 0.85em;
        cursor: pointer;
    }
</style>
<body>
<div class="container py-5">
    <?php include('header.php'); ?>
    <h1 class="mb-4 text-center">Обсуждение: Преимущества катания на велосипеде</h1>
    <p class="lead text-center">Обсудите статью и мероприятия, делитесь мнениями, задавайте вопросы 👇</p>

    <div class="card p-4 mb-4 shadow">
        <div class="chat-messages mb-4" style="max-height: 400px; overflow-y: auto;">
            <?php foreach ($chatMessages as $msg): ?>                    
                <div class="chat-message mb-3 p-2 border rounded bg-light position-relative">
                    <strong><?= htmlspecialchars($msg['username']) ?>:</strong>
                    <?= nl2br(htmlspecialchars($msg['message'])) ?>
                    <button 
                        type="button" 
                        class="btn btn-sm btn-link reply-btn position-absolute end-0 top-0 me-2 mt-1"
                        data-username="<?= htmlspecialchars($msg['username']) ?>">
                        Ответить
                    </button>
                    <form method="POST" action="connect/delete_message.php" style="display:inline;">
                        <input type="hidden" name="message" value="<?= htmlspecialchars($msg['message'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger ms-2">🗑️ Удалить</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" action="connect/send_message.php">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Ваше имя" required>
            </div>
            <div class="mb-3">
                <textarea name="message" class="form-control" placeholder="Ваше сообщение" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
        </form>
    </div>
    <a href="index.php" class="btn btn-secondary">← Назад к статьям</a>
    <?php include('footer.php'); ?>
</div>
<script src="./JS/chat.js"></script>
</body>
</html>

