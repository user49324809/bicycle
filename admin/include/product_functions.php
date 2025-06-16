<?php
require_once('db.php');

function updateProductById($id, $title, $category_id, $price, $description, $image) {
    $conn = openDbConnection();
    $stmt = $conn->prepare("UPDATE bike_products SET title = ?, category_id = ?, description = ?, price = ?, image = ? WHERE id = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("siidsi", $title, $category_id, $description, $price, $image, $id);
    return $stmt->execute();
}
// Функция для добавления нового товара
function addProduct($title, $category_id, $price, $description, $image) {
    $conn = openDbConnection();

    // SQL запрос для добавления товара в базу данных
    $stmt = $conn->prepare("INSERT INTO bike_products (title, category_id, description, price, image) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }

    // Связываем параметры с запросом (s - строка, i - целое число, d - число с плавающей точкой)
    $stmt->bind_param("siids", $title, $category_id, $description, $price, $image);

    return $stmt->execute(); // Выполняем запрос
}


// Функция для обновления заказа по ID
function updateOrderById($id, $customer_name, $product, $price, $quantity, $date, $status, $amount) {
    $conn = openDbConnection();
    $stmt = $conn->prepare("UPDATE orders SET customer_name = ?, product = ?, price = ?, quantity = ?, date = ?, status = ?, amount = ? WHERE id = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("ssdiissd", $customer_name, $product, $price, $quantity, $date, $status, $amount, $id);
    return $stmt->execute();
}

// Функция для добавления нового заказа
function addOrder($customer_name, $product, $price, $quantity, $date, $status, $amount) {
    $conn = openDbConnection();

    // SQL запрос для добавления заказа в базу данных
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, product, price, quantity, date, status, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }

    // Связываем параметры с запросом (s - строка, i - целое число, d - число с плавающей точкой)
    $stmt->bind_param("ssdiissd", $customer_name, $product, $price, $quantity, $date, $status, $amount);

    return $stmt->execute(); // Выполняем запрос
}

// Функция для удаления заказа по ID
function deleteOrderById($id) {
    $conn = openDbConnection();
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Функция для получения всех заказов
/*function selectAllOrders() {
    $conn = openDbConnection();
    
    $query = "
        SELECT 
            id,
            customer_name AS customer,
            product,
            price,
            quantity,
            date,
            status
        FROM orders
        ORDER BY date DESC, id DESC
    ";

    $result = $conn->query($query);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}*/

// Функция для получения заказа по ID
function selectOrderById($id) {
    $conn = openDbConnection();
    
    $query = "
        SELECT 
            id,
            customer_name AS customer,
            product,
            price,
            quantity,
            date,
            status
        FROM orders
        WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc(); 
}
