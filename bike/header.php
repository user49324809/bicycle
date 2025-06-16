<?php

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/main/header.css">
    <style>
        header{
            border-radius: 5px 5px 0 0;
        }
    </style>
</head>
<body>
    <header class="bg-info px-0">
        <div class="burger-menu">
            <div class="burger"></div>
            <div class="burger"></div>
            <div class="burger"></div>
        </div>
        <nav>
            <img class="img_logo" src="./image/logo_bike.png" alt="logo_bike_shop">
            <p class="p_logo"><?php echo "CycloShop"; ?></p>
            <div class="nav-links" id="navLinks">
                <a href="/">Главная</a>
                <a href="/about_us.php">О магазине</a>
                <a href="/contact.php">Контакты</a>
                <div class="dropdown">
                    <a href="#">Каталог</a>
                    <div class="dropdown-content bg-info">
                        <a href="/mountain_bikes.php">Горные велосипеды</a>
                        <a href="/road_bikes.php">Шоссейные велосипеды</a>
                        <a href="/city_bikes.php">Городские велосипеды</a>
                        <a href="/motor_bikes.php">Электровелосипеды</a>
                        <a href="/accessories.php">Аксессуары</a>
                    </div>
                </div>
                <a href="/events.php">Мероприятия</a>
            </div>
        </nav>
        <div class="header_button">
            <?php
            if (isset($_SESSION['login']) && isset($_SESSION['email'])) {
                echo '<button class="button btn btn-primary me-2" onclick="document.location=\'logout.php\'">Выйти</button>';
                echo '<button class="button btn btn-outline-primary me-2" onclick="document.location=\'personal_cabinet.php\'">Личный Кабинет</button>';
            } else {
                echo '<button class="button btn btn-outline-primary me-2" onclick="document.location=\'personal_cabinet.php\'">Личный Кабинет</button>';
                echo '<button class="button btn btn-outline-primary me-2" onclick="document.location=\'login.php\'">Войти</button>';
                echo '<button class="button btn btn-success me-2" onclick="document.location=\'registration.php\'">Зарегистрироваться</button>';
            }
            ?>
            <button class="button btn btn-warning" onclick="document.location='connect/cart.php'">
                <i class="bi bi-cart-fill"></i>
            </button>
        </div>
        <div class="header_button_adaptive">
            <?php
            if (isset($_SESSION['login']) && isset($_SESSION['email'])) {
                echo '<button class="button btn btn-primary me-2" onclick="document.location=\'logout.php\'">Выйти</button>';
            } else {
                echo '<button class="button btn btn-warning" onclick="document.location=\'login.php\'">В<i class="bi bi-box-arrow-in-right"></i></button>';
                echo '<button class="button btn btn-warning" onclick="document.location=\'registration.php\'">З<i class="bi bi-person-plus"></i></button>';
            }
            ?>
            <button class="button btn btn-warning" onclick="document.location='connect/cart.php'">
                <i class="bi bi-cart-fill"></i>
            </button>
        </div>
    </header>
    <script>
    const burger = document.querySelector('.burger-menu');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
</script>


</body>
</html>