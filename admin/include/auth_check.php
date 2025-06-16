<?php
session_start();

// Если в сессии нет пользователя, перенаправляем на страницу логина
if (!isset($_SESSION['user'])) {
  header("Location: ../login.php");
  exit;
}



