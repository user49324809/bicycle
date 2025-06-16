<?php
require_once('connect/db.php');
function selectAllCategories(){
    // Запрос для получения всех категорий
    $query = "SELECT * FROM bike_categories";  
    $conn = openDbConnection();
    $result = $conn->query($query);  
    if ($result) {
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row; 
        }
        
        return $categories;  
    } else {
        return [];  
    }
}
function getProductsByCategory($conn, $categoryId) {
    // Запрос для получения товаров по категории
    $query = "SELECT * FROM bike_products WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn = openDbConnection();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function selectOrders() {
    // Запрос для получения всех заказов
    $query = "SELECT * FROM orders_clients";  
    $conn = openDbConnection(); 
    $result = $conn->query($query); 
    if ($result) {
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row; 
        }
        return $orders;  
    } else {
        return [];  
    }
}

function selectPhotos() {
    $query = "SELECT * FROM user_photos";  
    $conn = openDbConnection(); 
    $result = $conn->query($query); 
    if ($result) {
        $photos = [];
        while ($row = $result->fetch_assoc()) {
            $photos[] = $row; 
        }
        return $photos;  
    } else {
        return []; 
    }
}


