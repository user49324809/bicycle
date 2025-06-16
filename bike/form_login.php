<?php
session_start();
include('init.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/connect/db.php");
$login = trim(filter_var($_POST['login']), FILTER_SANITIZE_SPECIAL_CHARS);
$pass = trim(filter_var($_POST['password']), FILTER_SANITIZE_SPECIAL_CHARS);

$hashedPass = password_hash($pass, PASSWORD_DEFAULT);
$conn = openDbConnection();

if (empty($login) || empty($pass)) {
    echo "Enter all input";
}else {
    $sql = "SELECT * FROM `registr` WHERE login = '$login' AND pass = '$pass'";
    $result = $conn -> query($sql);
    if ($result -> num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            $_SESSION['login'] = $row['login'];
            $_SESSION['pass'] = $row['pass'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_logged_in'] = true;
            // Переход в личный кабинет пользователя 
            header("Location: personal_cabinet.php");
            exit();
        }
    } else {
        echo "No user";
    }
}
