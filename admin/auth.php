<?php
session_start();

$users = json_decode(file_get_contents('data/users.json'), true);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$found = false;

foreach ($users as $user) {
  if ($user['username'] === $username && $user['password'] === $password) {
    $found = true;
    $_SESSION['user'] = $username;
    break;
  }
}

if ($found) {
  header("Location: index.php"); // или dashboard.php
  exit;
} else {
  $_SESSION['error'] = 'Неверный логин или пароль';
  header("Location: login.php");
  exit;
}
