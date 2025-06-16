<?php
session_start();
include('init.php');
require_once('connect/db.php');
$conn = openDbConnection();
$chatMessages = getAllChatMessages($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./events/events.css">
    <link rel="stylesheet" href="./main/header.css">
    <link rel="stylesheet" href="./main/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-panel {
    transition: opacity 0.3s ease, visibility 0.3s ease;
    opacity: 1;
    visibility: visible;
}
.chat-panel.d-none {
    opacity: 0;
    visibility: hidden;
}

        body, html{
            background-image: url("../image/bike_back.png");      
        }

        .container{
            max-width: 100% !important;
            margin: 0 auto;
            padding: 0 20px;
        }

        section{
            margin-top: 20px !important;
            margin-bottom: 20px;
            width: 95% !important;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container px-0">
        <?php include('header.php'); ?>
            <section class="events-section py-5 bg-light">
                <div class="container">
                    <h1 class="mb-5 text-center">Мероприятия и Статьи</h1>
                    <article class="event-article mb-5 p-4 bg-white shadow rounded">
                        <h2>Преимущества катания на велосипеде в городе</h2>
                        <p>Современные города все чаще ориентируются на экологичные и здоровые способы передвижения. Велосипед становится все более популярным видом транспорта, и не зря — его преимущества очевидны!</p>
                        <h3 class="mt-4">1. Улучшение физической формы</h3>
                        <p>Езда на велосипеде способствует укреплению мышц ног, улучшению сердечно-сосудистой системы и общему улучшению физической формы. Это отличная альтернатива фитнесу, которая помогает поддерживать здоровье.</p>
                        <h3 class="mt-4">2. Экологичность</h3>
                        <p>Велосипед не загрязняет атмосферу, не требует топлива и не оставляет углеродного следа. Это делает его идеальным выбором для тех, кто заботится о своем окружении и стремится снизить уровень загрязнения в городе.</p>
                        <h3 class="mt-4">3. Экономия времени и денег</h3>
                        <p>Велосипед — это дешевле, чем общественный транспорт, а особенно если вы выбираете поездки по пути, где часто бывают пробки. Велосипед позволяет быстро и без лишних затрат передвигаться по городу, особенно в условиях плотного движения.</p>
                        <h3 class="mt-4">4. Улучшение настроения</h3>
                        <p>Езда на велосипеде может быть отличным способом улучшить настроение. Это активность на свежем воздухе, которая способствует выработке эндорфинов — гормонов счастья. А прогулка по паркам или вдоль набережных еще больше помогает расслабиться.</p>
                        <h3 class="mt-4">5. Удобство в городе</h3>
                        <p>Многие города теперь активно развивают инфраструктуру для велосипедистов: велосипедные дорожки, специальные парковки, удобные маршруты. Это делает поездки на велосипеде безопасными и удобными для всех.</p>
                        <p class="mt-4"><strong>Заключение:</strong> Велосипед — это не просто средство передвижения, а стиль жизни, который помогает заботиться о своем здоровье и экологии города. Если вы еще не пробовали передвигаться на велосипеде по городу, самое время начать!</p>
                    </article>
                    <div class="upcoming-events mb-5">
                        <h2 class="mb-3">Предстоящие мероприятия</h2>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Велопробег по городу</strong> - 20 апреля 2025, старт с площади у парка (11:00).</li>
                            <li class="list-group-item"><strong>Мастер-класс по ремонту велосипедов</strong> - 25 апреля 2025, велоцентр на улице Технической (14:00).</li>
                            <li class="list-group-item"><strong>Велогонка "Скорость города"</strong> - 30 апреля 2025, центр города (9:00).</li>
                        </ul>
                    </div>
                    <a href="chat.php" class="btn btn-primary mb-4">Обсудить</a>
                    <div id="chatPanel" class="chat-panel card shadow p-4 mb-5 bg-white rounded d-none">
                        <div class="chat-panel-content position-relative">
                            <span id="closeChatBtn" class="close-chat-btn position-absolute top-0 end-0 fs-4" role="button">&times;</span>
                            <div id="chatMessages" class="chat-messages mb-3" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($chatMessages as $msg): ?>
                                    <div class="chat-message mb-2"><strong><?= htmlspecialchars($msg['username']) ?>:</strong> <?= htmlspecialchars($msg['message']) ?></div>
                                <?php endforeach; ?>
                            </div>
                            <form id="chatForm">
                                <div class="mb-3">
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Ваше имя" required>
                                </div>
                                <div class="mb-3">
                                    <textarea id="message" name="message" class="form-control" placeholder="Ваше сообщение" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        <?php include('footer.php'); ?>
    </div>
    <script src="./JS/chat.js"></script> 
</body>
</html>