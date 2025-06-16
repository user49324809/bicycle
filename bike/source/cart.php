<?php
session_start();
//include('../init.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/connect/db.php");
$conn = openDbConnection();
// Проверка, была ли отправлена форма с добавлением товара в корзину
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Получение товаров по id 
    $query = "SELECT * FROM bike_products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
    
    if ($product) {
        // Создание товара по данным из БД
        $cartItem = [
            'id' => $product['id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];

        // Если товар уже есть в корзине, обновляем его количество
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // Если товара нет в корзине, добавляем новый
            $_SESSION['cart'][$product_id] = $cartItem;
        }
    }
    // Редирект на страницу корзины после добавления товара
    header('Location: /connect/cart.php');
    exit();
}
?>
