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
    <link rel="stylesheet" href="contact/contact.css">
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html{
            background-image: url("../image/bike_back.png");      
        }

        .container{
            max-width: 100% !important;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <div class="container px-0">
        <?php include('header.php'); ?>
            <section class="delivery-section">
                <div class="content">
                    <div id="mountain-bike" class="tab-content active">
                        <h2 class="h3">Горные велосипеды</h2>
                        <p>Наши горные велосипеды предназначены для любителей активного отдыха и приключений на пересеченной местности. Мы предлагаем широкий выбор моделей для различных уровней подготовки.</p>
                        <h3 class="h4">Цены на велосипеды</h3>
                        <ul>
                            <li>Модель A - 30 000 рублей</li>
                            <li>Модель B - 45 000 рублей</li>
                            <li>Модель C - 60 000 рублей</li>
                        </ul>
                        <h3 class="h4">Преимущества горных велосипедов</h3>
                        <ul>
                            <li>Прочные рамы и амортизация</li>
                            <li>Специальные покрышки для жестких условий</li>
                            <li>Подходит для всех типов местности</li>
                        </ul>
                        <h3 class="h4">Процесс покупки</h3>
                        <div class="delivery-process d-flex justify-content-between">
                            <div class="step text-center">
                                <i class="fas fa-bicycle fa-2x"></i>
                                <p>Выберите модель и добавьте в корзину</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-credit-card fa-2x"></i>
                                <p>Оформите заказ и выберите способ оплаты</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-truck fa-2x"></i>
                                <p>Получите свой велосипед с доставкой на дом или заберите в магазине!</p>
                            </div>
                        </div>
                        <h3 class="h4">Условия доставки</h3>
                        <p>Мы осуществляем доставку по всей территории страны. Вы можете выбрать удобный способ доставки: стандартную или экспресс-доставку. Также доступна возможность самовывоза из магазина.</p>
                        <h3 class="h4">Условия самовывоза</h3>
                        <p>Вы можете забрать велосипед в нашем магазине по адресу: г. Москва, ул. Ленина, д. 10. Самовывоз доступен с понедельника по пятницу с 10:00 до 18:00.</p>
                    </div>
                    <div id="road-bike" class="tab-content">
                        <h2 class="h3">Шоссейные велосипеды</h2>
                        <p>Шоссейные велосипеды идеально подходят для тех, кто ценит скорость и комфорт на асфальтированных дорогах. Эти велосипеды отличаются легкостью и аэродинамичным дизайном.</p>
                        <h3 class="h4">Цены на велосипеды</h3>
                        <ul>
                            <li>Модель X - 40 000 рублей</li>
                            <li>Модель Y - 55 000 рублей</li>
                            <li>Модель Z - 70 000 рублей</li>
                        </ul>
                        <h3 class="h4">Преимущества шоссейных велосипедов</h3>
                        <ul>
                            <li>Легкий вес и высокая скорость</li>
                            <li>Аэродинамичные рамы и компоненты</li>
                            <li>Идеальны для длительных поездок</li>
                        </ul>
                        <h3 class="h4">Процесс покупки</h3>
                        <div class="delivery-process d-flex justify-content-between">
                            <div class="step text-center">
                                <i class="fas fa-bicycle fa-2x"></i>
                                <p>Выберите модель и добавьте в корзину</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-credit-card fa-2x"></i>
                                <p>Оформите заказ и выберите способ оплаты</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-truck fa-2x"></i>
                                <p>Получите велосипед с доставкой на дом или заберите в магазине!</p>
                            </div>
                        </div>
                        <h3 class="h4">Условия доставки</h3>
                        <p>Мы осуществляем доставку по всей территории страны. Вы можете выбрать удобный способ доставки: стандартную или экспресс-доставку. Также доступна возможность самовывоза из магазина.</p>
                        <h3 class="h4">Условия самовывоза</h3>
                        <p>Вы можете забрать велосипед в нашем магазине по адресу: г. Москва, ул. Ленина, д. 10. Самовывоз доступен с понедельника по пятницу с 10:00 до 18:00.</p>
                    </div>
                    <div id="electric-bike" class="tab-content">
                        <h2 class="h3">Электровелосипеды</h2>
                        <p>Электровелосипеды для тех, кто хочет получить больше комфорта и мощности без дополнительных усилий. Эти велосипеды оснащены электродвигателем для дополнительной помощи при движении.</p>
                        <h3 class="h4">Цены на велосипеды</h3>
                        <ul>
                            <li>Модель E1 - 50 000 рублей</li>
                            <li>Модель E2 - 75 000 рублей</li>
                            <li>Модель E3 - 100 000 рублей</li>
                        </ul>
                        <h3 class="h4">Преимущества электровелосипедов</h3>
                        <ul>
                            <li>Электродвигатель для легкости поездок</li>
                            <li>Подходит для городских и загородных маршрутов</li>
                            <li>Удобный и экономичный способ передвижения</li>
                        </ul>
                        <h3 class="h4">Процесс покупки</h3>
                        <div class="delivery-process d-flex justify-content-between">
                            <div class="step text-center">
                                <i class="fas fa-bicycle fa-2x"></i>
                                <p>Выберите модель и добавьте в корзину</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-credit-card fa-2x"></i>
                                <p>Оформите заказ и выберите способ оплаты</p>
                            </div>
                            <span class="arrow">→</span>
                            <div class="step text-center">
                                <i class="fas fa-truck fa-2x"></i>
                                <p>Получите электровелосипед с доставкой на дом или заберите в магазине!</p>
                            </div>
                        </div>
                        <h3 class="h4">Условия доставки</h3>
                        <p>Мы осуществляем доставку по всей территории страны. Вы можете выбрать удобный способ доставки: стандартную или экспресс-доставку. Также доступна возможность самовывоза из магазина.</p>
                        <h3 class="h4">Условия самовывоза</h3>
                        <p>Вы можете забрать электровелосипед в нашем магазине по адресу: г. Москва, ул. Ленина, д. 10. Самовывоз доступен с понедельника по пятницу с 10:00 до 18:00.</p>
                    </div>
                </div>
                <div class="contact-info mt-4">
                    <h3 class="h4">Контактные данные</h3>
                    <p>Адрес компании: г. Москва, ул. Ленина, д. 10</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                </div>
                <div class="delivery-notifications mt-4">
                    <h3 class="h4">Подписка на уведомления о доставке</h3>
                    <p>Подпишитесь на уведомления о статусе вашей доставки через электронную почту или SMS. Вы можете указать оба способа связи.</p>
                    <form action="/connect/subscribe_notice.php" method="POST">
                        <div class="form-group">
                            <label for="email" >Электронная почта:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Введите ваш email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Номер телефона (необязательно):</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Введите ваш номер телефона">
                        </div>
                        <button type="submit" class="btn btn-primary">Подписаться</button>
                    </form>
                </div>
            </section>
        <?php include('footer.php'); ?>
    </div>
</body>
</html>