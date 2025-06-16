<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // Перенаправляем на главную страницу после выхода
exit();
?>
