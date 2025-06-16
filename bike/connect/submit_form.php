<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $address_post = "inna6903zaharova@yandex.ru";
    $theme = "Your report";
$address_post = "inna6903zaharova@yandex.ru";
$theme = "Your report";
$message = "Ваше имя: ".$_POST['name']."<br>";
$message .= "Ваш email: ".$_POST['email']."<br>";
$message .= "Сообщение: ".$_POST['message']."<br>";
$headers  = 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
$headers .= "From: noreply@yourdomain.ru\r\n";
    mail($address_post, $theme, $message, $headers);
        echo "Сообщение отправлено!";
    } else {
        echo "Ошибка: данные не были отправлены.";
    }
