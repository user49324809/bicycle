<?php
require_once('include/db.php');

function selectAllOrders(){
    // Запрос для получения всех заказов
    $query = "SELECT * FROM orders";  
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
?>
