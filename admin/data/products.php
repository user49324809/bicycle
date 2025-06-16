<?php
require_once('include/auth_check.php');
require_once('include/db.php');
include('include/header.php');

// Получаем товары
$sql = "SELECT * FROM bike_categories";
$result = $conn->query($sql);
$latestProducts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $latestProducts[] = $row;
    }
}


$totalProducts = count($latestProducts);
$totalUsers = 1;
?>
