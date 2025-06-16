<?php
session_start();
require_once('connect/db.php');
include('init.php');
require_once('connect/comment.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/category.php");
$conn = openDbConnection();
$reviews = selectAllReview();
$categories = selectAllCategories(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/main.css">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="main/categories.css">
    <link rel="stylesheet" href="main/container.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
    <body>
        <div class="container px-0">
            <?php include('header.php'); ?>
                <main class="main px-0">
                    <section class="title py-5 bg-light position-relative overflow-hidden" id="title">
                        <div class="container_title text-center">
                            <h2 class="mb-4 fw-bold">
                            <i class="bi bi-bicycle me-2 text-primary"></i>
                            ПРОЦЕСС ПОКУПКИ ВЕЛОСИПЕДОВ И ЧТО ВХОДИТ В НЕГО
                            <i class="bi bi-gear-fill ms-2 text-secondary"></i>
                            </h2>
                            <ul class="nav nav-pills justify-content-center flex-row gap-3 students_list">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary d-flex align-items-center gap-2" href="#infoblock">
                                    <i class="bi bi-shop"></i> О МАГАЗИНЕ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary d-flex align-items-center gap-2" href="#hero">
                                    <i class="bi bi-list-ul"></i> КАТЕГОРИИ ВЕЛОСИПЕДОВ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-success d-flex align-items-center gap-2" href="#action">
                                    <i class="bi bi-percent"></i> АКЦИИ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-warning d-flex align-items-center gap-2" href="#bonus">
                                    <i class="bi bi-gift"></i> БОНУСЫ И СКИДКИ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-info d-flex align-items-center gap-2" href="#reviews">
                                    <i class="bi bi-chat-dots"></i> ОТЗЫВЫ КЛИЕНТОВ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-dark d-flex align-items-center gap-2" href="#guarantees">
                                    <i class="bi bi-shield-check"></i> ГАРАНТИИ И ОБСЛУЖИВАНИЕ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-danger d-flex align-items-center gap-2" href="#footer">
                                    <i class="bi bi-telephone"></i> КОНТАКТЫ
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="position-absolute top-0 start-0 bg-primary opacity-10 rounded-circle" style="width: 200px; height: 200px; transform: translate(-50%, -50%);"></div>
                        <div class="position-absolute bottom-0 end-0 bg-warning opacity-10 rounded-circle" style="width: 150px; height: 150px; transform: translate(50%, 50%);"></div>
                    </section>
                    <section class="section_info py-1 bg-info" id="infoblock">
                        <div class="container">
                            <div class="row align-items-center gy-4">
                                <div class="col-lg-6">
                                    <h2 class="mb-4 text-primary"><i class="bi bi-shop-window me-2"></i>О магазине</h2>
                                    <p>Наш магазин велосипедов был основан в 2020 году и с тех пор успешно предлагает широкий ассортимент велосипедов 
                                    для всех категорий клиентов: от профессионалов до новичков. Мы гордимся тем, что работаем напрямую с клиентами,
                                    предоставляя им только качественные товары и услуги.</p>
                                    <p>Мы продаем горные, шоссейные и городские велосипеды, а также аксессуары и запасные части для них. Мы стараемся
                                    предоставить нашим клиентам лучшие цены и сервис, а также гарантируем высокое качество всех наших товаров.</p>
                                    <p class="fw-semibold mt-4">Наши преимущества:</p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bi bi-bicycle text-success me-2"></i>Широкий выбор велосипедов разных категорий</li>
                                        <li class="mb-2"><i class="bi bi-person-check-fill text-info me-2"></i>Квалифицированные консультанты</li>
                                        <li class="mb-2"><i class="bi bi-patch-check-fill text-primary me-2"></i>Гарантия на все товары</li>
                                        <li class="mb-2"><i class="bi bi-truck text-warning me-2"></i>Быстрая доставка по всей стране</li>
                                        <li class="mb-2"><i class="bi bi-headset text-danger me-2"></i>Поддержка и консультации после покупки</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="../image/bike_fon.png" alt="Изображение магазина велосипедов" class="img-fluid rounded shadow">
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="categories py-5 bg-light" id = "hero">
                        <div class="container">
                            <h2 class="text-center mb-5 text-primary fw-bold display-6">
                                <i class="bi bi-tags-fill me-2"></i>Категории велосипедов
                            </h2>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                                <?php foreach ($categories as $category): ?>
                                    <div class="col">
                                        <div class="card h-100 shadow-sm border-0 rounded-4 hover-card">
                                            <div class="img-container rounded-top-4 overflow-hidden">
                                                <img src="<?php echo $category['image']; ?>" class="card-img-top img-fluid" alt="<?php echo $category['name']; ?>">
                                            </div>
                                            <div class="card-body d-flex flex-column p-4">
                                                <h5 class="card-title fw-semibold"><?php echo $category['name']; ?></h5>
                                                <p class="card-text text-muted"><?php echo $category['description']; ?></p>
                                                <a href="<?php echo $category['link']; ?>" class="btn btn-primary mt-auto rounded-pill">
                                                    <i class="bi bi-arrow-right-circle me-1"></i>Перейти
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>
                    <style>
                        .hover-card {
                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                        }

                        .hover-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                        }

                        .img-container img {
                            height: 200px;
                            object-fit: cover;
                            transition: transform 0.3s ease;
                        }

                        .img-container:hover img {
                            transform: scale(1.05);
                        }
                    </style>
                    <section class="reviews py-5" style="background: linear-gradient(145deg, #e3f2fd, #ffffff);" id="reviews">
                        <div class="container">
                            <h2 class="text-center text-primary mb-4">
                                <i class="bi bi-chat-square-heart-fill me-2">
                                </i>Отзывы покупателей
                            </h2>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                                <label for="ratingFilter" class="form-label me-2 mb-0">Фильтр по рейтингу:</label>
                                <select id="ratingFilter" class="form-select w-auto">
                                    <option value="">Все</option>
                                    <option value="1">1 звезда</option>
                                    <option value="2">2 звезды</option>
                                    <option value="3">3 звезды</option>
                                    <option value="4">4 звезды</option>
                                    <option value="5">5 звезд</option>
                                </select>
                                <button id="filterButton" class="btn btn-outline-primary">Применить</button>
                            </div>
                            <div class="row g-4" id="reviewModule">
                                <?php
                                foreach ($reviews as $review) {
                                    echo "
                                    <div class='col-md-6' data-rating='{$review->rating}'>
                                        <div class='card_reviews h-100 shadow-sm'>
                                            <div class='card-reviews bg-8'>
                                                <h5 class='card-title'><i class='bi bi-person-circle me-1'></i>{$review->username}</h5>
                                                <p class='card-text'>{$review->review_text}</p>
                                                <p class='mb-2'>
                                                <strong>Рейтинг:</strong>";
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $review->rating ? '<span class="text-warning">★</span>' : '<span class="text-muted">☆</span>';
                                                }
                                                echo "</p>";
                                                if ($review->color_issue) {
                                                    echo "<p class='mb-2'><span class='badge bg-danger'>Проблема</span></p>";
                                                }
                                                echo "
                                                <p class='text-muted mb-0'><i class='bi bi-clock me-1'></i>{$review->review_date}</p>
                                            </div>
                                        </div>
                                    </div>";
                                }
                                ?>
                            </div>
                            <div class="chatForm mt-5 card shadow p-4">
                                <h5 class="mb-3"><i class="bi bi-pencil-fill me-2"></i>Оставьте свой отзыв:</h5>                                             
                                <input type="text" id="username" class="form-control mb-3" placeholder="Ваше имя">                       
                                <textarea id="review_text" class="form-control mb-3" rows="4" placeholder="Напишите ваш отзыв"></textarea>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="color_issue">
                                    <label class="form-check-label" for="color_issue">Проблема</label>
                                </div>
                                <input type="date" id="review_date" class="form-control mb-3" value="<?= date('Y-m-d') ?>">
                                <div class="mb-3">
                                    <label class="form-label">Рейтинг:</label>
                                    <div id="starRating">
                                        <span class="star" data-value="1">☆</span>
                                        <span class="star" data-value="2">☆</span>
                                        <span class="star" data-value="3">☆</span>
                                        <span class="star" data-value="4">☆</span>
                                        <span class="star" data-value="5">☆</span>
                                    </div>
                                </div>
                                <button id="submit_review" class="btn btn-success">
                                    <i class="bi bi-envelope-fill me-1"></i>Отправить
                                </button>
                            </div>
                        </div>
                    </section>
                    <section class="promo-offer my-5 py-4 bg-light shadow-sm rounded" id="action">
                        <div class="container">
                            <h2 class="text-center mb-4">🔥 Акция! Успей купить со скидкой</h2>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <p class="lead">Только до конца недели: получите скидку 30% на аксесуары!</p>
                                    <ul class="list-unstyled mb-4">
                                        <li><i class="fas fa-percent me-2 text-success"></i> Скидка применяется автоматически</li>
                                        <li><i class="fas fa-clock me-2 text-danger"></i> Акция ограничена по времени</li>
                                    </ul>
                                    <button class="btn btn-danger btn-lg" onclick="document.location='./connect/cart.php'">
                                        <i class="fas fa-shopping-cart me-2"></i>Купить сейчас
                                    </button>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h4 class="mb-3">До конца акции осталось:</h4>
                                    <div id="countdown" class="fs-1 fw-bold text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="guarantees" id="guarantees">
                        <h2>Гарантии</h2>
                        <ul class="guarantees-list row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                            <li><i class="fas fa-question-circle"></i> Гарантия на все велосипеды</li>
                            <li><i class="fas fa-truck"></i> Бесплатная доставка по всей стране</li>
                            <li><i class="fas fa-wrench"></i> Сервисное обслуживание</li>
                            <li><i class="fas fa-headset"></i> Поддержка клиентов 24/7</li>
                            <li><i class="fas fa-check-circle"></i> Гарантия возврата товара в течение 14 дней</li>
                            <li><i class="fas fa-cogs"></i> Замена деталей по гарантии</li>
                        </ul>
                    </section>
                    <section class="sidebar bg-light border-end p-4" id="bonus">
                        <div class="sidebar-content">
                            <div class="burger-menu d-flex flex-column gap-1 mb-4" onclick="toggleSidebar()" role="button" style = "display: none">
                                <div class="bg-dark rounded" style="height: 4px; width: 25px;"></div>
                                <div class="bg-dark rounded" style="height: 4px; width: 25px;"></div>
                                <div class="bg-dark rounded" style="height: 4px; width: 25px;"></div>
                            </div>
                            <h5 class="text-primary mb-3 text-center"><i class="bi bi-bookmark-star me-2"></i>Полезные ресурсы</h5>
                            <ul class="nav flex-column mb-4 text-center row-5">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#bikes"><i class="bi bi-tree-fill me-2 text-success"></i>Горные велосипеды</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#road_bikes"><i class="bi bi-speedometer2 me-2 text-danger"></i>Шоссейные велосипеды</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#city_bikes"><i class="bi bi-building me-2 text-secondary"></i>Городские велосипеды</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#accessories"><i class="bi bi-tools me-2 text-warning"></i>Аксессуары</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#faq"><i class="bi bi-question-circle me-2 text-info"></i>Частые вопросы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="#contact"><i class="bi bi-envelope me-2 text-primary"></i>Контакты</a>
                                </li>
                            </ul>
                            <h5 class="text-primary mb-3 text-center"><i class="bi bi-envelope-paper-fill me-2"></i>Подписка на новости</h5>
                            <form class="d-flex flex-column gap-2" method="POST" action="connect/subscribe.php">
                                <input type="email" name="email" class="form-control" placeholder="Ваш email" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i>Подписаться
                                </button>
                            </form>
                        </div>
                        <div class="toggle mt-4 text-center" onclick="toggleSidebar()" role="button">
                            <span class="text-muted"><i class="bi bi-chevron-double-left"></i> Скрыть</span>
                        </div>
                    </section>
                </main>
            <?php include('footer.php'); ?>
        </div>
    </body>
    <script src="./JS/main.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./JS/comment.js"></script>
    <script src="./JS/action.js"></script>
    <script src="./JS/burger_menu.js"></script>
    <script src="./JS/review_sort.js"></script>
    <script>AOS.init();</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const countdownEl = document.getElementById('countdown');
        const endTime = new Date("2025-05-30T23:59:59").getTime(); 
        function pad(n) {
            return n < 10 ? '0' + n : n;
        }
        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;
            if (distance <= 0) {
                countdownEl.textContent = "00:00:00";
                clearInterval(timerInterval); 
                return;
            }
            const hours = pad(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
            const minutes = pad(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
            const seconds = pad(Math.floor((distance % (1000 * 60)) / 1000));

            countdownEl.textContent = `${hours}:${minutes}:${seconds}`;
        }
        updateTimer(); 
        const timerInterval = setInterval(updateTimer, 1000);
        });
    </script>
</html>