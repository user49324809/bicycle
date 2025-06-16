<?php
session_start();
include('init.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <link rel="stylesheet" href="about_us/about_us.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html{
            background-image: url("../image/bike_back.png");      
        }

        header{
            width: 100% !important;
        }

        main {
            width: 95% !important;
            align-items: center !important;
            text-align: center;
            margin: 0 auto;
            margin-bottom: 20px !important;
        }


        .company-info{
            margin-top: 40px;
        }
        .carousel-inner img {
            width: 80%; 
            height: 80%; 
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 50px;  
            height: 50px;
            background-color: #007bff;
            border-radius: 50%;
        }

        .carousel-control-prev,
        .carousel-control-next {
            font-size: 30px;
            color: #007bff;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 123, 255, 0.1);
            color: #0056b3;
        }

        .products {
            width: 100%;
        }

        .carousel-inner {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container px-0">
        <?php include('header.php'); ?>
            <main>
                <section class="company-info py-5 bg-light text-center container rounded shadow-sm">
                    <h2 class="mb-4 text-primary">О нашем магазине</h2>
                    <p class="lead">
                        Мы - ваш надежный партнер в мире велосипедов! Мы предлагаем широкий выбор велосипедов для различных нужд и 
                        уровней подготовки. Наши специалисты помогут выбрать идеальный велосипед, а также предоставить качественное 
                        обслуживание и аксессуары.
                    </p>
                </section>
                <section class="products py-5 bg-body-tertiary container rounded shadow-sm">
                    <h2 class="mb-4 text-success text-center">Наши товары</h2>
                    <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner text-center">
                            <div class="carousel-item active">
                                <div class="position-relative">
                                    <img src="./image/bike_slide.png" class="d-block mx-auto img-fluid" style="height: 450px;" alt="Горные велосипеды">
                                    <div class="position-absolute top-50 start-50 translate-middle text-white fs-3 fw-bold">
                                        Мега быстрые
                                    </div>
                                </div>
                                <h5 class="mt-3">Горные велосипеды</h5>
                            </div>
                            <div class="carousel-item">
                                <div class="position-relative">
                                    <img src="./image/road_bike.png" class="d-block mx-auto img-fluid" style="height: 450px;" alt="Шоссейные велосипеды">
                                    <div class="position-absolute top-50 start-50 translate-middle text-white fs-3 fw-bold">
                                        Отличные для дорог
                                    </div>
                                </div>
                                <h5 class="mt-3">Шоссейные велосипеды</h5>
                            </div>
                            <div class="carousel-item">
                                <div class="position-relative">
                                    <img src="./image/hybrid_bike.png" class="d-block mx-auto img-fluid" style="height: 450px;" alt="Гибридные велосипеды">
                                    <div class="position-absolute top-50 start-50 translate-middle text-white fs-3 fw-bold">
                                        Универсальные для всего
                                    </div>
                                </div>
                                <h5 class="mt-3">Гибридные велосипеды</h5>
                            </div>
                            <div class="carousel-item">
                                <div class="position-relative">
                                    <img src="image/acc_bike.png" class="d-block mx-auto img-fluid" style="height: 450px;" alt="Аксессуары">
                                    <div class="position-absolute top-50 start-50 translate-middle text-white fs-3 fw-bold">
                                        Все для вашего комфорта
                                    </div>
                                </div>
                                <h5 class="mt-3">Аксессуары (шлемы, насосы, сумки)</h5>
                            </div>
                            <div class="carousel-item">
                                <div class="position-relative">
                                    <img src="image/acc_bike.png" class="d-block mx-auto img-fluid" style="height: 450px;" alt="Запчасти">
                                    <div class="position-absolute top-50 start-50 translate-middle text-white fs-3 fw-bold">
                                        Надежные запчасти
                                    </div>
                                </div>
                                <h5 class="mt-3">Запчасти и инструменты для ремонта</h5>
                            </div>
                        </div>
                        <button class="carousel-control-prev btn-lg" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Предыдущий</span>
                        </button>
                        <button class="carousel-control-next btn-lg" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Следующий</span>
                        </button>
                    </div>
                </section>
                <section class="certificates py-5 bg-light container rounded shadow-sm">
                    <h2 class="mb-4 text-primary text-center">Сертификаты и награды</h2>
                    <p class="lead text-center">Мы гордимся качеством нашей продукции, а также сертификатами, подтверждающими высокие стандарты наших велосипедов и аксессуаров. Наш магазин постоянно работает над улучшением качества обслуживания и расширением ассортимента.</p>
                    <div class="certificate-gallery d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <img src="./image/bike_sign.png" alt="Сертификат 1" class="img-thumbnail" style="max-width: 200px;">
                        <img src="./image/bike_sign.png" alt="Сертификат 2" class="img-thumbnail" style="max-width: 200px;">
                        <img src="./image/bike_sign.png" alt="Сертификат 3" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </section>
                <section class="team py-5 bg-body-tertiary container rounded shadow-sm">
                    <h2 class="mb-5 text-center text-primary">Наши сотрудники</h2>
                    <div class="employee-card d-flex align-items-start gap-4 mb-4 p-4 bg-white rounded shadow employee-hover">
                        <img src="./image/avatar_boy.png" alt="Сотрудник 1" class="img-fluid rounded-circle shadow-sm" style="width: 120px; height: 120px;">
                        <div class="employee-info">
                            <h3 class="mb-1">Алексей Смирнов</h3>
                            <p class="mb-1 fw-semibold text-muted">Менеджер по продажам</p>
                            <p>Поможет вам выбрать идеальный велосипед для любых условий.</p>
                            <p class="mb-1">
                                <strong>📞 Телефон:</strong> 
                                <a href="tel:+79001234567" class="text-decoration-none text-success hover-underline">+7 (900) 123-45-67</a>
                            </p>
                            <p class="mb-0">
                                <strong>✉️ Email:</strong> 
                                <a href="mailto:alexey.smirnov@example.com" class="text-decoration-none text-success hover-underline">alexey.smirnov@example.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="employee-card d-flex align-items-start gap-4 mb-4 p-4 bg-white rounded shadow employee-hover">
                        <img src="./image/avatar_girl.png" alt="Сотрудник 2" class="img-fluid rounded-circle shadow-sm" style="width: 120px; height: 120px;">
                        <div class="employee-info">
                            <h3 class="mb-1">Ольга Васильева</h3>
                            <p class="mb-1 fw-semibold text-muted">Консультант по велоаксессуарам</p>
                            <p>Предоставит советы по выбору аксессуаров и защитного оборудования.</p>
                            <p class="mb-1">
                                <strong>📞 Телефон:</strong> 
                                <a href="tel:+79009876543" class="text-decoration-none text-success hover-underline">+7 (900) 987-65-43</a>
                            </p>
                            <p class="mb-0">
                                <strong>✉️ Email:</strong> 
                                <a href="mailto:olga.vasileva@example.com" class="text-decoration-none text-success hover-underline">olga.vasileva@example.com</a>
                            </p>
                        </div>
                    </div>
                </section>
                <section class="contact py-5 bg-light container rounded shadow-sm">
                    <h2 class="mb-4 text-center text-primary">Контакты</h2>
                    <p class="text-center lead mb-5">Свяжитесь с нами, и мы ответим на все ваши вопросы! Будем рады помочь выбрать велосипед и аксессуары.</p>
                    <form action="connect/submit_form.php" method="post" class="mx-auto" style="max-width: 600px;">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ваше имя:</label>
                            <input type="text" id="name" name="name" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Ваш email:</label>
                            <input type="email" id="email" name="email" required class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label">Сообщение:</label>
                            <textarea id="message" name="message" rows="4" required class="form-control"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="button btn btn-primary">Отправить</button>
                        </div>
                    </form>
                </section>
            </main>
        <?php include('footer.php'); ?>
    </div>
    <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>