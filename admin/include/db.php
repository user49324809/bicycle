<?php
// Настройки подключения к базе данных
function openDbConnection(){
    $servername = "db";
    $username = "root";
    $password = "root";
    $dbname = "bike_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    return $conn;
}
?>
