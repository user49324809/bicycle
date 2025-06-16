<?php
session_start();
session_unset();  // Удаляем все переменные сессии
session_destroy(); // Уничтожаем сессию
//require_once('include/auth_check.php');
header("Location: login.php");  // Перенаправляем на страницу входа
exit;
